<?php
/*
 *
 *  This is file is part of DGL's tech stack.
 *
 *  @copyright (c) 2024, Deadan Group Limited (DGL).
 *  @link https://www.dgl.co.ke/products
 *  All rights reserved.
 *
 *  <code>Build something people want!</code>
 */

/**
 *
 * (c) www.dgl.co.ke
 *
 * <code> Build something people want </code>
 *
 */

namespace DGL\Salami\Plugins;

use DGL\Salami\Dto\SalamiApiResponse;
use DGL\Salami\Events\SalamiSmsProcessed;

/**
 *
 */
class SalamiSms extends BaseSdk
{
    /**
     * @param        $to
     * @param        $message
     * @param null $appId
     *
     * @return \DGL\Salami\Dto\SalamiApiResponse
     * @throws \Exception
     */
    public function sendRaw($to, $message, $appId = null)
    {
        return $this->send([
            'to' => $to,
            'message' => $message,
        ], $this->getAppId($appId));
    }

    /**
     * @param array $payload
     * @param null $appId
     *
     * @return \DGL\Salami\Dto\SalamiApiResponse
     * @throws \Exception
     */
    public function send(array $payload, $appId = null)
    {
        $response = $this->call("/sms/apps/" . $this->getAppId($appId) . "/send", 'POST', $payload);

        $data = $response->getAttribute('data');

        if ($data) {
            event(new SalamiSmsProcessed($data));
        }

        return $response;
    }

    /**
     * @param array $payload
     *
     * @return SalamiApiResponse
     * @throws \GuzzleHttp\GuzzleException
     */
    public function getSmsApps(array $payload)
    {
        return $this->call('/sms/apps', 'GET', $payload);
    }

    /**
     * @param $appId
     *
     * @return SalamiApiResponse
     * @throws \Exception
     * @throws \GuzzleHttp\GuzzleException
     */
    public function getSmsApp($appId)
    {
        return $this->call('/sms/apps/' . $appId, 'GET');
    }

    /**
     * @param $appId
     *
     * @return SalamiApiResponse
     * @throws \Exception
     * @throws \GuzzleHttp\GuzzleException
     */
    public function getAppInbox($appId)
    {
        return $this->call('/sms/apps/' . $this->getAppId($appId) . '/inbox', 'GET');
    }

    /**
     * @param $appId
     *
     * @return SalamiApiResponse
     * @throws \Exception
     * @throws \GuzzleHttp\GuzzleException
     */
    public function getAppOutbox($appId)
    {
        return $this->call('/sms/apps/' . $this->getAppId($appId) . '/outbox', 'GET');
    }

    /**
     * @param $appId
     *
     * @return SalamiApiResponse
     * @throws \Exception
     * @throws \GuzzleHttp\GuzzleException
     */
    public function getAppsCalls($appId)
    {
        return $this->call('/sms/apps/' . $this->getAppId($appId) . '/calls', 'GET');
    }

    /**
     * @param array $payload
     *
     * @return SalamiApiResponse
     * @throws \GuzzleHttp\GuzzleException
     */
    public function createApp(array $payload)
    {
        return $this->call('/sms/apps/create', 'POST', $payload);
    }

    /**
     * @param $smsId
     *
     * @return SalamiApiResponse
     * @throws \GuzzleHttp\GuzzleException
     */
    public function getSingleMessage($smsId)
    {
        return $this->call('/sms/' . $smsId, 'GET');
    }
}
