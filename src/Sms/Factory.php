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
    private $http;

    /**
     * @var LoggerInterface
     */
    private $logger = null;

    /**
     * @var array
     */
    private $config = [];

    /**
     * @param array $config
     * @return Factory
     */
    public function withConfig(array $config): Factory
    {
        $this->config = $config;
        return $this;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function config($key, $default = null)
    {
        return array_get($this->config, $key, $default);
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
            'http_errors'     => $this->config('http_errors', false), //let users handle errors
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
        $endpoint = rtrim($this->config('baseEndpoint'), '/\\');
        if ($withVersion && $version = $this->config('version')) {
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
                'Authorization' => 'Bearer ' . $this->config('accessToken'),
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
        return $this->fetch('/api/apps/' , 'GET');
    }

    /**
     * @param array $payload
     * @return array
     */
    public function send(array $payload = [])
    {
        return $this->fetch("/api/apps/" . $this->config('appId') . "/send", 'POST', $payload);
    }

    /**
     * @return array
     */
    public function getAppInbox()
    {
        return $this->fetch('/api/apps/' . $this->config('appId') . '/inbox', 'GET');
    }

    /**
     * @return array
     */
    public function getAppOutbox()
    {
        return $this->fetch('/api/apps/' . $this->config('appId') . '/outbox', 'GET');
    }

    /**
     * @return array
     */
    public function getAppsCalls()
    {
        return $this->fetch('/api/apps/' . $this->config('appId') . '/calls', 'GET');
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