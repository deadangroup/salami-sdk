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
     * @var mixed
     */
    private $oauthClientId;

    /**
     * @var mixed
     */
    private $oauthClientSecret;

    /**
     * @var
     */
    private $accessToken;

    /**
     * @var string
     */
    private $baseEndpoint = "https://sms.deadangroup.com/api";

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
     * @param mixed $oauthClientSecret
     * @return Factory
     */
    public function withOauthClientSecret($oauthClientSecret)
    {
        $this->oauthClientSecret = $oauthClientSecret;
        return $this;
    }

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
     * @param mixed $oauthClientId
     * @return Factory
     */
    public function withOauthClientId($oauthClientId)
    {
        $this->oauthClientId = $oauthClientId;
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
     * @param $endpoint
     * @param $payload
     * @return array
     */
    public function fetch($endpoint, $method, $payload = [])
    {
        $baseEndpoint = rtrim($this->baseEndpoint . $this->getVersion(), '/\\');
        $url = $baseEndpoint . $endpoint;
        $this->log("DeadanSMS API URL:" . $url);
        $this->log("DeadanSMS API Payload:", $payload);

        $response = $this->getHttpClient()->request(strtoupper($method), $url, [
            'json'    => $payload,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->generateAccessToken(),
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
    private function generateAccessToken()
    {
        if (!is_null($this->accessToken)) {
            return $this->accessToken;
        }

        // Setup the guzzle client
        $client = $this->getHttpClient();

        // Attempt to fetch an access token
        $response = $client->request('POST', $this->baseEndpoint . '/oauth/token',
            [
                'form_params' => [
                    'grant_type'    => 'client_credentials',
                    'client_id'     => $this->oauthClientId,
                    'client_secret' => $this->oauthClientSecret,
                    'scope'         => '*',
                ],
            ]);

        // Get the result
        $result = json_decode($response->getBody(), true);
        $this->accessToken = $result['access_token'];

        return $this->accessToken;
    }

    /**
     * @param array $payload
     * @return array
     */
    public function send(array $payload = [])
    {
        return $this->fetch('/send', 'POST', $payload);
    }

    /**
     * @param array $payload
     * @return array
     */
    public function getSmsApps(array $payload = [])
    {
        return $this->fetch('/apps', 'GET', $payload);
    }

    /**
     * @param int $appId
     * @return array
     */
    public function getAppInbox($appId)
    {
        return $this->fetch('/apps/' . $appId . '/inbox', 'GET');
    }

    /**
     * @param int $appId
     * @return array
     */
    public function getAppOutbox($appId)
    {
        return $this->fetch('/apps/' . $appId . '/outbox', 'GET');
    }

    /**
     * @param int $appId
     * @return array
     */
    public function getAppsCalls($appId)
    {
        return $this->fetch('/apps/' . $appId . '/calls', 'GET');
    }

    /**
     * @param array $payload
     * @return array
     */
    public function createApp(array $payload = [])
    {
        return $this->fetch('/apps/create', 'POST', $payload);
    }

    /**
     * @param $smsId
     * @return array
     */
    public function getSingleMessage($smsId)
    {
        return $this->fetch('/sms/' . $smsId, 'GET');
    }
}