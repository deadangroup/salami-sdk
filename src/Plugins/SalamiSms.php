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

class SalamiSms extends BaseSdk
{
    /**
     * @param $to
     * @param $message
     * @param  null  $appId
     * @return \Deadan\Salami\Transaction
     * @throws \Exception
     */
    public function sendRaw($to, $message, $appId = null)
    {
        return $this->send($this->getAppId($appId), [
            'to'      => $to,
            'message' => $message,
        ]);
    }

    /**
     * @param  array  $payload
     * @param  null  $appId
     * @return \Deadan\Salami\Transaction
     * @throws \Exception
     */
    public function send(array $payload = [], $appId = null)
    {
        return $this->fetch("/sms/apps/".$this->getAppId($appId)."/send", 'POST', $payload);
    }

    /**
     * @param  array  $payload
     *
     * @return Transaction
     * @throws \GuzzleHttp\GuzzleException
     */
    public function getSmsApps(array $payload = [])
    {
        return $this->fetch('/sms/apps', 'GET', $payload);
    }

    /**
     * @param $appId
     *
     * @return Transaction
     * @throws \Exception
     * @throws \GuzzleHttp\GuzzleException
     */
    public function getSmsApp($appId)
    {
        return $this->fetch('/sms/apps/'.$appId, 'GET');
    }

    /**
     * @param $appId
     *
     * @return Transaction
     * @throws \Exception
     * @throws \GuzzleHttp\GuzzleException
     */
    public function getAppInbox($appId)
    {
        return $this->fetch('/sms/apps/'.$this->getAppId($appId).'/inbox', 'GET');
    }

    /**
     * @param $appId
     *
     * @return Transaction
     * @throws \Exception
     * @throws \GuzzleHttp\GuzzleException
     */
    public function getAppOutbox($appId)
    {
        return $this->fetch('/sms/apps/'.$this->getAppId($appId).'/outbox', 'GET');
    }

    /**
     * @param $appId
     *
     * @return Transaction
     * @throws \Exception
     * @throws \GuzzleHttp\GuzzleException
     */
    public function getAppsCalls($appId)
    {
        return $this->fetch('/sms/apps/'.$this->getAppId($appId).'/calls', 'GET');
    }

    /**
     * @param  array  $payload
     *
     * @return Transaction
     * @throws \GuzzleHttp\GuzzleException
     */
    public function createApp(array $payload = [])
    {
        return $this->fetch('/sms/apps/create', 'POST', $payload);
    }

    /**
     * @param $smsId
     *
     * @return Transaction
     * @throws \GuzzleHttp\GuzzleException
     */
    public function getSingleMessage($smsId)
    {
        return $this->fetch('/sms/'.$smsId, 'GET');
    }
}
