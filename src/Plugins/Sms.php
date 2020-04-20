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
     * @return array
     * @throws \Exception
     */
    public function sendRaw($to, $message, $appId)
    {
        return $this->send(
            $appId,
            [
                'to'      => $to,
                'message' => $message,
            ]
        );
    }
    
    /**
     * @param array $payload
     *
     * @return array
     */
    public function getSmsApps(array $payload = [])
    {
        return $this->sdk->fetch('/api/apps', 'GET', $payload);
    }
    
    /**
     * @param $appId
     *
     * @return array
     * @throws \Exception
     */
    public function getSmsApp($appId)
    {
        return $this->sdk->fetch('/api/apps/'.$this->getAppId($appId), 'GET');
    }
    
    /**
     * @param array $payload
     *
     * @param       $appId
     *
     * @return array
     * @throws \Exception
     */
    public function send(array $payload = [], $appId)
    {
        return $this->sdk->fetch("/api/apps/".$this->getAppId($appId)."/send", 'POST', $payload);
    }
    
    /**
     * @param $appId
     *
     * @return array
     * @throws \Exception
     */
    public function getAppInbox($appId)
    {
        return $this->sdk->fetch('/api/apps/'.$this->getAppId($appId).'/inbox', 'GET');
    }
    
    /**
     * @param $appId
     *
     * @return array
     * @throws \Exception
     */
    public function getAppOutbox($appId)
    {
        return $this->sdk->fetch('/api/apps/'.$this->getAppId($appId).'/outbox', 'GET');
    }
    
    /**
     * @param $appId
     *
     * @return array
     * @throws \Exception
     */
    public function getAppsCalls($appId)
    {
        return $this->sdk->fetch('/api/apps/'.$this->getAppId($appId).'/calls', 'GET');
    }
    
    /**
     * @param array $payload
     *
     * @return array
     */
    public function createApp(array $payload = [])
    {
        return $this->sdk->fetch('/api/apps/create', 'POST', $payload);
    }
    
    /**
     * @param $smsId
     *
     * @return array
     */
    public function getSingleMessage($smsId)
    {
        return $this->sdk->fetch('/api/sms/'.$smsId, 'GET');
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
}