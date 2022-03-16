<?php

/**
 *
 * (c) www.deadangroup.com
 *
 * <code> Build something people want </code>
 *
 */

namespace Deadan\Salami\Plugins;

use Deadan\Salami\Jobs\ProcessSalamiApiResponse;


/**
 * Class SalamiPay
 *
 * @package Deadan\Salami\Plugins
 */
class SalamiPay extends BaseSdk
{
    /**
     * @param  array  $payload
     * @return \Deadan\Salami\SalamiApiResponse
     * @throws \Exception
     */
    public function queryPayments(array $payload = [])
    {
        return $this->call("/payments/".$this->getAppId()."/queryPayments", 'GET', $payload);
    }

    /**
     * @param $paymentId
     * @return \Deadan\Salami\SalamiApiResponse
     * @throws \Exception
     */
    public function getPayment($paymentId)
    {
        return $this->call("/payments/".$this->getAppId()."/payment/".$paymentId, 'GET');
    }

    /**
     * @param  array  $payload
     * @return \Deadan\Salami\SalamiApiResponse
     * @throws \Exception
     */
    public function checkBalance(array $payload = [])
    {
        return $this->call("/payments/".$this->getAppId()."/checkBalance", 'GET', $payload);
    }

    /**
     * @param  array  $payload
     * @return \Deadan\Salami\SalamiApiResponse
     * @throws \Exception
     */
    public function extractPayment(array $payload = [])
    {
        return $this->call("/payments/".$this->getAppId()."/extractPayment", 'GET', $payload);
    }

    /**
     * @param  array  $payload
     * @return \Deadan\Salami\SalamiApiResponse
     * @throws \Exception
     */
    public function fetchPayments(array $payload = [])
    {
        return $this->call("/payments/".$this->getAppId()."/fetchPayments", 'GET', $payload);
    }

    /**
     * @param $paymentId
     * @return \Deadan\Salami\SalamiApiResponse
     * @throws \Exception
     */
    public function getPaymentStatus($paymentId)
    {
        return $this->call("/payments/".$this->getAppId()."/getPaymentStatus/".$paymentId, 'GET');
    }

    /**
     * @param  array  $payload
     * @return \Deadan\Salami\SalamiApiResponse
     * @throws \Exception
     */
    public function registerUrls(array $payload = [])
    {
        return $this->call("/payments/".$this->getAppId()."/registerUrls", 'GET', $payload);
    }

    /**
     * @param  array  $payload
     * @return \Deadan\Salami\SalamiApiResponse
     * @throws \Exception
     */
    public function requestPayment(array $payload = [])
    {
        return $this->call("/payments/".$this->getAppId()."/requestPayment", 'GET', $payload);
    }
}
