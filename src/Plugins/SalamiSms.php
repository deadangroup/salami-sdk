<?php

/**
 *
 * (c) www.deadangroup.com
 *
 * <code> Build something people want </code>
 *
 */

namespace Deadan\Salami\Plugins;

use Deadan\Salami\Dto\SalamiApiResponse;
use Deadan\Salami\Events\SalamiSmsProcessed;

/**
 *
 */
class SalamiSms extends BaseSdk
{
    /**
     * @param        $to
     * @param        $message
     * @param  null  $appId
     *
     * @return \Deadan\Salami\Dto\SalamiApiResponse
     * @throws \Exception
     */
    public function sendRaw($to, $message, $appId = null)
    {
        return $this->send([
            'to'      => $to,
            'message' => $message,
        ], $this->getAppId($appId));
    }

    /**
     * @param  array  $payload
     * @param  null  $appId
     *
     * @return \Deadan\Salami\Dto\SalamiApiResponse
     * @throws \Exception
     */
    public function send(array $payload = [], $appId = null)
    {
        $response = $this->call("/sms/apps/".$this->getAppId($appId)."/send", 'POST', $payload);

        event(new SalamiSmsProcessed($response->getAttribute('data')));

        return $response;
    }

    /**
     * @param  array  $payload
     *
     * @return SalamiApiResponse
     * @throws \GuzzleHttp\GuzzleException
     */
    public function getSmsApps(array $payload = [])
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
        return $this->call('/sms/apps/'.$appId, 'GET');
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
        return $this->call('/sms/apps/'.$this->getAppId($appId).'/inbox', 'GET');
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
        return $this->call('/sms/apps/'.$this->getAppId($appId).'/outbox', 'GET');
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
        return $this->call('/sms/apps/'.$this->getAppId($appId).'/calls', 'GET');
    }

    /**
     * @param  array  $payload
     *
     * @return SalamiApiResponse
     * @throws \GuzzleHttp\GuzzleException
     */
    public function createApp(array $payload = [])
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
        return $this->call('/sms/'.$smsId, 'GET');
    }
}
