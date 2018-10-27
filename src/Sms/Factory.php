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
     * @var
     */
    private $accessToken;

    /**
     * @var string
     */
    private $baseEndpoint = "https://sms.deadangroup.com";

    /**
     * @var Client
     */
    private $http;

    /**
     * The DeadanSMS API version
     * @var string
     */
    private $version = null; //v1

    /**
     * @var LoggerInterface
     */
    private $logger = null;

    /**
     * @param string $baseEndpoint
     * @return Factory
     */
    public function withBaseEndpoint(string $baseEndpoint): Factory
    {
        $this->baseEndpoint = $baseEndpoint;
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
     * @param mixed $version
     * @return Factory
     */
    public function withVersion($version)
    {
        $this->version = $version;
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
            'http_errors'     => true, //let users handle errors
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
     * @return null|string
     */
    public function getVersion()
    {
        if (!is_null($this->version)) {
            return '/' . $this->version;
        }
        return null;
    }

    /**
     * @param bool $withVersion
     * @return string
     */
    public function getBaseEndpoint($withVersion = false): string
    {
        $endpoint = rtrim($this->baseEndpoint, '/\\');
        if ($withVersion) {
            $endpoint = $endpoint . '/' . $this->getVersion();
        }
        return rtrim($endpoint, '/\\');
    }

    /**
     * @param mixed $accessToken
     * @return Factory
     */
    public function withAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
        return $this;
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
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
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
     * Fetch an access token from API
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
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
     * @param $appId
     * @return array
     */
    public function getSmsApp($appId)
    {
        return $this->fetch('/api/apps/' . $appId, 'GET');
    }

    /**
     * @param array $payload
     * @return array
     */
    public function send($appId, array $payload = [])
    {
        return $this->fetch("/api/apps/$appId/send", 'POST', $payload);
    }

    /**
     * @param int $appId
     * @return array
     */
    public function getAppInbox($appId)
    {
        return $this->fetch('/api/apps/' . $appId . '/inbox', 'GET');
    }

    /**
     * @param int $appId
     * @return array
     */
    public function getAppOutbox($appId)
    {
        return $this->fetch('/api/apps/' . $appId . '/outbox', 'GET');
    }

    /**
     * @param int $appId
     * @return array
     */
    public function getAppsCalls($appId)
    {
        return $this->fetch('/api/apps/' . $appId . '/calls', 'GET');
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