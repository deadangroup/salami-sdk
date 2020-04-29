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

class Pay
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
     * @param       $appId
     * @param array $payload
     *
     * @return array
     * @throws \Exception
     * @throws \GuzzleHttp\GuzzleException
     */
    public function queryTransactions($appId, array $payload = [])
    {
        return $this->sdk->fetch("/payments/".$this->getAppId($appId)."/queryTransactions", 'GET', $payload);
    }
    
    /**
     * @param       $appId
     * @param       $transactionId
     *
     * @return array
     * @throws \Exception
     * @throws \GuzzleHttp\GuzzleException
     */
    public function getTransaction($appId, $transactionId)
    {
        return $this->sdk->fetch("/payments/".$this->getAppId($appId)."/transaction/".$transactionId, 'GET');
    }
    
    /**
     * @param       $appId
     *
     * @param array $payload
     *
     * @return array
     * @throws \Exception
     * @throws \GuzzleHttp\GuzzleException
     */
    public function checkBalance($appId, array $payload = [])
    {
        return $this->sdk->fetch("/payments/".$this->getAppId($appId)."/checkBalance", 'GET', $payload);
    }
    
    /**
     * @param       $appId
     *
     * @param array $payload
     *
     * @return array
     * @throws \Exception
     * @throws \GuzzleHttp\GuzzleException
     */
    public function extractTransaction($appId, array $payload = [])
    {
        return $this->sdk->fetch("/payments/".$this->getAppId($appId)."/extractTransaction", 'GET', $payload);
    }
    
    /**
     * @param       $appId
     *
     * @param array $payload
     *
     * @return array
     * @throws \Exception
     * @throws \GuzzleHttp\GuzzleException
     */
    public function fetchTransactions($appId, array $payload = [])
    {
        return $this->sdk->fetch("/payments/".$this->getAppId($appId)."/fetchTransactions", 'GET', $payload);
    }
    
    /**
     * @param       $appId
     * @param       $transactionId
     *
     * @return array
     * @throws \Exception
     * @throws \GuzzleHttp\GuzzleException
     */
    public function getTransactionStatus($appId, $transactionId)
    {
        return $this->sdk->fetch("/payments/".$this->getAppId($appId)."/getTransactionStatus/".$transactionId, 'GET');
    }
    
    /**
     * @param       $appId
     * @param array $payload
     *
     * @return array
     * @throws \Exception
     * @throws \GuzzleHttp\GuzzleException
     */
    public function registerUrls($appId,  array $payload = [])
    {
        return $this->sdk->fetch("/payments/".$this->getAppId($appId)."/registerUrls", 'GET',$payload);
    }
    
    /**
     * @param       $appId
     * @param array $payload
     *
     * @return array
     * @throws \Exception
     * @throws \GuzzleHttp\GuzzleException
     */
    public function requestPayment($appId,  array $payload = [])
    {
        return $this->sdk->fetch("/payments/".$this->getAppId($appId)."/requestPayment", 'GET',$payload);
    }
    
    /**
     * @param int $appId
     *
     * @return \Deadan\Salami\Plugins\Pay
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
        
        throw new \Exception("Please specify a PaymentApp Id");
    }
}