<?php

/**
 *
 * (c) www.deadangroup.com
 *
 * <code> Build something people want </code>
 *
 */

namespace Deadan\Salami\Plugins;

use Deadan\Salami\Sdk;
use Deadan\Salami\Transaction;

class Sms
{
    /**
     * @var \Deadan\Salami\Sdk
     */
    private $sdk;
    
    /**
     * @var int
     */
    private $appId;
    
    /**
     * Pay constructor.
     */
    public function __construct(Sdk $sdk)
    {
        $this->sdk = $sdk;
    }
    
    /**
     * @param $to
     * @param $message
     *
     * @param $appId
     *
     * @return Transaction
     * @throws \Exception
     * @throws \GuzzleHttp\GuzzleException
     */
    public function sendRaw($to, $message, $appId)
    {
        return $this->send($appId, [
                'to'      => $to,
                'message' => $message,
            ]);
    }
    
    /**
     * @param array $payload
     *
     * @param       $appId
     *
     * @return Transaction
     * @throws \Exception
     * @throws \GuzzleHttp\GuzzleException
     */
    public function send(array $payload = [], $appId)
    {
        return $this->sdk->fetch("/sms/apps/".$this->getAppId($appId)."/send", 'POST', $payload);
    }
    
    /**
     * @param $fallbackAppId
     *
     * @return int
     * @throws \Exception
     */
    public function getAppId($fallbackAppId)
    {
        if ($fallbackAppId) {
            return $fallbackAppId;
        }
        
        if ($this->appId) {
            return $this->appId;
        }
        
        throw new \Exception("Please specify an SmsApp Id");
    }
    
    /**
     * @param int $appId
     *
     * @return Sms
     */
    public function setAppId($appId)
    {
        $this->appId = $appId;
        
        return $this;
    }
    
    /**
     * @param array $payload
     *
     * @return Transaction
     * @throws \GuzzleHttp\GuzzleException
     */
    public function getSmsApps(array $payload = [])
    {
        return $this->sdk->fetch('/sms/apps', 'GET', $payload);
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
        return $this->sdk->fetch('/sms/apps/'.$this->getAppId($appId), 'GET');
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
        return $this->sdk->fetch('/sms/apps/'.$this->getAppId($appId).'/inbox', 'GET');
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
        return $this->sdk->fetch('/sms/apps/'.$this->getAppId($appId).'/outbox', 'GET');
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
        return $this->sdk->fetch('/sms/apps/'.$this->getAppId($appId).'/calls', 'GET');
    }
    
    /**
     * @param array $payload
     *
     * @return Transaction
     * @throws \GuzzleHttp\GuzzleException
     */
    public function createApp(array $payload = [])
    {
        return $this->sdk->fetch('/sms/apps/create', 'POST', $payload);
    }
    
    /**
     * @param $smsId
     *
     * @return Transaction
     * @throws \GuzzleHttp\GuzzleException
     */
    public function getSingleMessage($smsId)
    {
        return $this->sdk->fetch('/sms/'.$smsId, 'GET');
    }
}
