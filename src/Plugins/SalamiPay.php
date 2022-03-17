<?php

/**
 *
 * (c) www.deadangroup.com
 *
 * <code> Build something people want </code>
 *
 */

namespace Deadan\Salami\Plugins;


/**
 * Class SalamiPay
 *
 * @package Deadan\Salami\Plugins
 */
class SalamiPay extends BaseSdk
{
    /**
     * @param  array  $payload
     * @param         $appId
     * @return \Deadan\Salami\SalamiApiResponse
     * @throws \Exception
     */
    public function queryPayments(array $payload = [], $appId)
    {
        return $this->call("/payments/".$this->getAppId($appId)."/queryPayments", 'GET', $payload);
    }

    /**
     * @param $paymentId
     * @param $appId
     * @return \Deadan\Salami\SalamiApiResponse
     * @throws \Exception
     */
    public function getPayment($paymentId, $appId)
    {
        return $this->call("/payments/".$this->getAppId($appId)."/payment/".$paymentId, 'GET');
    }

    /**
     * @param  array  $payload
     * @param         $appId
     * @return \Deadan\Salami\SalamiApiResponse
     * @throws \Exception
     */
    public function checkBalance(array $payload = [], $appId)
    {
        return $this->call("/payments/".$this->getAppId($appId)."/checkBalance", 'GET', $payload);
    }

    /**
     * @param  array  $payload
     * @param         $appId
     * @return \Deadan\Salami\SalamiApiResponse
     * @throws \Exception
     */
    public function extractPayment(array $payload = [], $appId)
    {
        return $this->call("/payments/".$this->getAppId($appId)."/extractPayment", 'GET', $payload);
    }

    /**
     * @param  array  $payload
     * @param         $appId
     * @return \Deadan\Salami\SalamiApiResponse
     * @throws \Exception
     */
    public function fetchPayments(array $payload = [], $appId)
    {
        return $this->call("/payments/".$this->getAppId($appId)."/fetchPayments", 'GET', $payload);
    }

    /**
     * @param $paymentId
     * @param $appId
     * @return \Deadan\Salami\SalamiApiResponse
     * @throws \Exception
     */
    public function getPaymentStatus($paymentId, $appId)
    {
        return $this->call("/payments/".$this->getAppId($appId)."/getPaymentStatus/".$paymentId, 'GET');
    }

    /**
     * @param  array  $payload
     * @param         $appId
     * @return \Deadan\Salami\SalamiApiResponse
     * @throws \Exception
     */
    public function registerUrls(array $payload = [], $appId)
    {
        return $this->call("/payments/".$this->getAppId($appId)."/registerUrls", 'GET', $payload);
    }

    /**
     * @param  array  $payload
     * @param         $appId
     * @return \Deadan\Salami\SalamiApiResponse
     * @throws \Exception
     */
    public function requestPayment(array $payload = [], $appId)
    {
        return $this->call("/payments/".$this->getAppId($appId)."/requestPayment", 'GET', $payload);
    }
}
