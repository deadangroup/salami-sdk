<?php

/**
 *
 * (c) www.deadangroup.com
 *
 * <code> Build something people want </code>
 *
 */

namespace Deadan\Salami;

use Deadan\Salami\Plugins\Pay;
use Deadan\Salami\Plugins\Sms;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

class Sdk
{
    /**
     * @var Client
     */
    public $http;
    
    /**
     * @var LoggerInterface
     */
    public $logger = null;
    
    /**
     * @var string
     */
    public $version = '';
    
    /**
     * @var string
     */
    public $baseEndpoint = 'http://salami.co.ke/api';
    
    /**
     * @var string
     */
    public $appId;
    
    /**
     * @var string
     */
    public $apiToken;
    
    /**
     * @var bool
     */
    public $httpErrors = false;
    
    /**
     * @param array $config
     *
     * @return Sdk
     */
    public function withConfig(array $config)
    {
        $this->version = isset($config['version']) ? $config['version'] : $this->version;
        $this->baseEndpoint = isset($config['baseEndpoint']) ? $config['baseEndpoint'] : $this->baseEndpoint;
        $this->appId = isset($config['appId']) ? $config['appId'] : $this->appId;
        $this->apiToken = isset($config['apiToken']) ? $config['apiToken'] : $this->apiToken;
        $this->apiToken = isset($config['apiToken']) ? $config['apiToken'] : $this->apiToken;
        $this->httpErrors = isset($config['httpErrors']) ? $config['httpErrors'] : $this->httpErrors;
        
        return $this;
    }
    
    /**
     * @param Client $http
     *
     * @return Sdk
     */
    public function withHttp(Client $http)
    {
        $this->http = $http;
        
        return $this;
    }
    
    /**
     * @return Client
     */
    public function getHttpClient()
    {
        if ($this->http) {
            return $this->http;
        }
        
        return $this->http = new Client(
            [
                'timeout'         => 60,
                'allow_redirects' => true,
                'http_errors'     => $this->httpErrors, //let users handle errors
                'verify'          => false,
            ]
        );
    }
    
    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }
    
    /**
     * @param LoggerInterface $logger
     *
     * @return Sdk
     */
    public function withLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
        
        return $this;
    }
    
    /**
     * @param bool $withVersion
     *
     * @return string
     */
    public function getBaseEndpoint($withVersion = false)
    {
        $endpoint = rtrim($this->baseEndpoint, '/\\');
        if ($withVersion && $version = $this->version) {
            $endpoint = $endpoint.'/'.$version;
        }
        
        return rtrim($endpoint, '/\\');
    }
    
    /**
     * @param       $endpoint
     * @param       $method
     * @param array $payload
     *
     * @return array
     * @throws \GuzzleHttp\GuzzleException
     */
    public function fetch($endpoint, $method, $payload = [])
    {
        $baseEndpoint = $this->getBaseEndpoint(true);
        $url = $baseEndpoint.$endpoint;
        $this->log("DeadanSMS API URL:".$url);
        $this->log("DeadanSMS API Payload:", $payload);
        
        $response = $this->getHttpClient()
                         ->request(
                             strtoupper($method),
                             $url,
                             [
                                 'json'    => $payload,
                                 'headers' => [
                                     'Accept'        => 'application/json',
                                     'Authorization' => 'Bearer '.$this->apiToken,
                                 ],
                             ]
                         );
        
        $contents = $response->getBody()
                             ->getContents();
        $this->log("DeadanSMS API Response:".$contents);
        
        return json_decode($contents);
    }
    
    /**
     * @param       $message
     * @param array $context
     */
    public function log($message, $context = [])
    {
        if ($this->logger) {
            $this->logger->log("info", $message, $context);
        }
    }
    
    /**
     * @return \Deadan\Salami\Plugins\Sms
     */
    public function sms()
    {
        return new Sms($this);
    }
    
    /**
     * @return \Deadan\Salami\Plugins\Pay
     */
    public function pay()
    {
        return new Pay($this);
    }
}