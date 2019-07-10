<?php

/**
 * This file is part of the Deadan Group Software Stack
 *
 * (c) James Ngugi <james@deadangroup.com>
 *
 * <code> Build something people want </code>
 *
 */

namespace Deadan\Support\Sms;

use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

class Factory
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
    public $baseEndpoint = 'http://sms.deadangroup.com';

    /**
     * @var string
     */
    public $appId;

    /**
     * @var string
     */
    public $accessToken;

    /**
     * @var bool
     */
    public $httpErrors = false;

    /**
     * @param array $config
     * @return Factory
     */
    public function withConfig(array $config): Factory
    {
        $this->version = array_get($config, 'version', $this->version);
        $this->baseEndpoint = array_get($config, 'baseEndpoint', $this->baseEndpoint);
        $this->appId = array_get($config, 'appId', $this->appId);
        $this->accessToken = array_get($config, 'accessToken', $this->accessToken);
        $this->httpErrors = array_get($config, 'httpErrors', $this->httpErrors);
        return $this;
    }

    /**
     * @param Client $http
     * @return Factory
     */
    public function withHttp(Client $http): Factory
    {
        $this->http = $http;
        return $this;
    }

    /**
     * @return Client
     */
    public function getHttpClient(): Client
    {
        if ($this->http) {
            return $this->http;
        }
        return $this->http = new Client([
            'timeout'         => 60,
            'allow_redirects' => true,
            'http_errors'     => $this->httpErrors, //let users handle errors
            'verify'          => false,
        ]);
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    /**
     * @param LoggerInterface $logger
     * @return Factory
     */
    public function withLogger(LoggerInterface $logger): Factory
    {
        $this->logger = $logger;
        return $this;
    }

    /**
     * @param bool $withVersion
     * @return string
     */
    public function getBaseEndpoint($withVersion = false): string
    {
        $endpoint = rtrim($this->baseEndpoint, '/\\');
        if ($withVersion && $version = $this->version) {
            $endpoint = $endpoint . '/' . $version;
        }
        return rtrim($endpoint, '/\\');
    }

    /**
     * @param $endpoint
     * @param $payload
     * @return array
     */
    public function fetch($endpoint, $method, $payload = [])
    {
        $baseEndpoint = $this->getBaseEndpoint(true);
        $url = $baseEndpoint . $endpoint;
        $this->log("DeadanSMS API URL:" . $url);
        $this->log("DeadanSMS API Payload:", $payload);

        $response = $this->getHttpClient()->request(strtoupper($method), $url, [
            'json'    => $payload,
            'headers' => [
                'Accept'        => 'application/json',
                'Authorization' => 'Bearer ' . $this->accessToken,
            ],
        ]);

        $contents = $response->getBody()->getContents();
        $this->log("DeadanSMS API Response:" . $contents);

        return json_decode($contents);
    }

    /**
     * @param $message
     * @param array $context
     */
    public function log($message, $context = [])
    {
        if ($this->logger) {
            $this->logger->log("info", $message, $context);
        }
    }

    /**
     * @param $to
     * @param $message
     * @return array
     */
    public function sendRaw($to, $message)
    {
        return $this->send([
            'to'      => $to,
            'message' => $message,
        ]);
    }

    /**
     * @param array $payload
     * @return array
     */
    public function getSmsApps(array $payload = [])
    {
        return $this->fetch('/api/apps', 'GET', $payload);
    }

    /**
     * @return array
     */
    public function getSmsApp()
    {
        return $this->fetch('/api/apps/', 'GET');
    }

    /**
     * @param array $payload
     * @return array
     */
    public function send(array $payload = [])
    {
        return $this->fetch("/api/apps/" . $this->appId . "/send", 'POST', $payload);
    }

    /**
     * @return array
     */
    public function getAppInbox()
    {
        return $this->fetch('/api/apps/' . $this->appId . '/inbox', 'GET');
    }

    /**
     * @return array
     */
    public function getAppOutbox()
    {
        return $this->fetch('/api/apps/' . $this->appId . '/outbox', 'GET');
    }

    /**
     * @return array
     */
    public function getAppsCalls()
    {
        return $this->fetch('/api/apps/' . $this->appId . '/calls', 'GET');
    }

    /**
     * @param array $payload
     * @return array
     */
    public function createApp(array $payload = [])
    {
        return $this->fetch('/api/apps/create', 'POST', $payload);
    }

    /**
     * @param $smsId
     * @return array
     */
    public function getSingleMessage($smsId)
    {
        return $this->fetch('/api/sms/' . $smsId, 'GET');
    }
}