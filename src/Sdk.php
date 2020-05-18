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
     * Sdk constructor.
     *
     * @param string $apiToken
     */
    public function __construct($apiToken)
    {
        $this->withApiToken($apiToken);
    }
    
    /**
     * @param \GuzzleHttp\Client $http
     *
     * @return Sdk
     */
    public function withHttp($http)
    {
        $this->http = $http;
        
        return $this;
    }
    
    /**
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return Sdk
     */
    public function withLogger($logger)
    {
        $this->logger = $logger;
        
        return $this;
    }
    
    /**
     * @param string $version
     *
     * @return Sdk
     */
    public function withVersion($version)
    {
        $this->version = $version;
        
        return $this;
    }
    
    /**
     * @param string $baseEndpoint
     *
     * @return Sdk
     */
    public function withBaseEndpoint($baseEndpoint)
    {
        $this->baseEndpoint = $baseEndpoint;
        
        return $this;
    }
    
    /**
     * @param string $appId
     *
     * @return Sdk
     */
    public function withAppId($appId)
    {
        $this->appId = $appId;
        
        return $this;
    }
    
    /**
     * @param string $apiToken
     *
     * @return Sdk
     */
    public function withApiToken($apiToken)
    {
        $this->apiToken = $apiToken;
        
        return $this;
    }
    
    /**
     * @param bool $httpErrors
     *
     * @return Sdk
     */
    public function withHttpErrors($httpErrors)
    {
        $this->httpErrors = $httpErrors;
        
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