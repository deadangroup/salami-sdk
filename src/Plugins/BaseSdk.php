<?php

/**
 *
 * (c) www.deadangroup.com
 *
 * <code> Build something people want </code>
 *
 */

namespace Deadan\Salami\Plugins;

use Deadan\Salami\Transaction;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

abstract class BaseSdk
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
    public $baseUrl = 'https://salami.co.ke/api';

    /**
     * @var string
     */
    public $appId;

    /**
     * @var string
     */
    public $apiToken;

    /**
     * @var string
     */
    public $webhookSecret;

    /**
     * @var bool
     */
    public $httpErrors = false;

    /**
     * @var bool
     */
    public $signatureVerification = false;

    /**
     * @var string
     */
    public $signatureHeaderName = 'x_salami_signature';

    /**
     * BaseSdk constructor.
     * @param $apiToken
     * @param $webhookSecret
     */
    public function __construct($apiToken, $webhookSecret)
    {
        $this->apiToken = $apiToken;
        $this->webhookSecret = $webhookSecret;
    }

    /**
     * @param $signatureVerification
     * @return BaseSdk
     */
    public function setSignatureVerification($signatureVerification)
    {
        $this->signatureVerification = $signatureVerification;

        return $this;
    }

    /**
     * @param  string  $signatureHeaderName
     * @return BaseSdk
     */
    public function setSignatureHeaderName(string $signatureHeaderName): BaseSdk
    {
        $this->signatureHeaderName = $signatureHeaderName;
        return $this;
    }

    /**
     * @param  string  $apiToken
     *
     * @return BaseSdk
     */
    public function withApiToken($apiToken)
    {
        $this->apiToken = $apiToken;

        return $this;
    }

    /**
     * @param  string  $webhookSecret
     *
     * @return BaseSdk
     */
    public function withWebhookSecret($webhookSecret)
    {
        $this->webhookSecret = $webhookSecret;

        return $this;
    }

    /**
     * @param  \GuzzleHttp\Client  $http
     *
     * @return BaseSdk
     */
    public function withHttp($http)
    {
        $this->http = $http;

        return $this;
    }

    /**
     * @param  \Psr\Log\LoggerInterface  $logger
     *
     * @return BaseSdk
     */
    public function withLogger($logger)
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * @param  string  $version
     *
     * @return BaseSdk
     */
    public function withVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @param  string  $baseUrl
     *
     * @return BaseSdk
     */
    public function withBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }

    /**
     * @param  string  $appId
     *
     * @return BaseSdk
     */
    public function withAppId($appId)
    {
        $this->appId = $appId;

        return $this;
    }

    /**
     * @param $fallbackAppId
     *
     * @return int
     * @throws \Exception
     */
    public function getAppId($fallbackAppId = null)
    {
        if ($fallbackAppId) {
            return $fallbackAppId;
        }

        if ($this->appId) {
            return $this->appId;
        }

        throw new \Exception("Please specify an APP Id");
    }

    /**
     * @param $appId
     * @return $this
     */
    public function setAppId($appId)
    {
        $this->appId = $appId;

        return $this;
    }

    /**
     * @param  bool  $httpErrors
     *
     * @return BaseSdk
     */
    public function withHttpErrors($httpErrors)
    {
        $this->httpErrors = $httpErrors;

        return $this;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param         $endpoint
     * @param         $method
     * @param  array  $payload
     *
     * @return Transaction
     * @throws \GuzzleHttp\GuzzleException
     */
    public function call($endpoint, $method, $payload = [])
    {
        $baseUrl = $this->getBaseUrl(true);
        $url = $baseUrl.$endpoint;
        $this->log("Salami API URL:".$url);
        $this->log("Salami API Payload:", $payload);

        $response = $this->getHttpClient()
            ->request(strtoupper($method), $url, [
                'form_params' => $payload,
                'query'       => $payload,
                'headers'     => [
                    'Accept'        => 'application/json',
                    'Authorization' => 'Bearer '.$this->apiToken,
                ],
            ]);

        $contents = $response->getBody()
            ->getContents();
        $this->log("Salami API Response:".$contents);

        return Transaction::buildFromApiCall(json_decode($contents, true));
    }

    /**
     * @param  bool  $withVersion
     *
     * @return string
     */
    public function getBaseUrl($withVersion = false)
    {
        $endpoint = rtrim($this->baseUrl, '/\\');
        if ($withVersion && $version = $this->version) {
            $endpoint = $endpoint.'/'.$version;
        }

        return rtrim($endpoint, '/\\');
    }

    /**
     * @param         $message
     * @param  array  $context
     */
    public function log($message, $context = [])
    {
        if ($this->logger) {
            $this->logger->log("info", $message, $context);
        }
    }

    /**
     * @return Client
     */
    public function getHttpClient()
    {
        if ($this->http) {
            return $this->http;
        }

        return $this->http = new Client([
            'timeout'         => 60,
            'allow_redirects' => true,
            'http_errors'     => $this->httpErrors,
            //let users handle errors
            'verify'          => false,
        ]);
    }
}
