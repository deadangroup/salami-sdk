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
use Illuminate\Http\Request;

class SalamiPay extends BaseSdk
{
    /**
     * @param       $appId
     * @param  array  $payload
     *
     * @return Transaction
     * @throws \Exception
     * @throws \GuzzleHttp\GuzzleException
     */
    public function queryTransactions($appId, array $payload = [])
    {
        return $this->fetch("/payments/".$this->getAppId($appId)."/queryTransactions", 'GET', $payload);
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

    /**
     * @param  int  $appId
     *
     * @return \Deadan\Salami\Plugins\SalamiPay
     */
    public function setAppId($appId)
    {
        $this->appId = $appId;

        return $this;
    }

    /**
     * @param       $appId
     * @param       $transactionId
     *
     * @return Transaction
     * @throws \Exception
     * @throws \GuzzleHttp\GuzzleException
     */
    public function getTransaction($appId, $transactionId)
    {
        return $this->fetch("/payments/".$this->getAppId($appId)."/transaction/".$transactionId, 'GET');
    }

    /**
     * @param       $appId
     *
     * @param  array  $payload
     *
     * @return Transaction
     * @throws \Exception
     * @throws \GuzzleHttp\GuzzleException
     */
    public function checkBalance($appId, array $payload = [])
    {
        return $this->fetch("/payments/".$this->getAppId($appId)."/checkBalance", 'GET', $payload);
    }

    /**
     * @param       $appId
     *
     * @param  array  $payload
     *
     * @return Transaction
     * @throws \Exception
     * @throws \GuzzleHttp\GuzzleException
     */
    public function extractTransaction($appId, array $payload = [])
    {
        return $this->fetch("/payments/".$this->getAppId($appId)."/extractTransaction", 'GET', $payload);
    }

    /**
     * @param       $appId
     *
     * @param  array  $payload
     *
     * @return Transaction
     * @throws \Exception
     * @throws \GuzzleHttp\GuzzleException
     */
    public function fetchTransactions($appId, array $payload = [])
    {
        return $this->fetch("/payments/".$this->getAppId($appId)."/fetchTransactions", 'GET', $payload);
    }

    /**
     * @param       $appId
     * @param       $transactionId
     *
     * @return Transaction
     * @throws \Exception
     * @throws \GuzzleHttp\GuzzleException
     */
    public function getTransactionStatus($appId, $transactionId)
    {
        return $this->fetch("/payments/".$this->getAppId($appId)."/getTransactionStatus/".$transactionId, 'GET');
    }

    /**
     * @param       $appId
     * @param  array  $payload
     *
     * @return Transaction
     * @throws \Exception
     * @throws \GuzzleHttp\GuzzleException
     */
    public function registerUrls($appId, array $payload = [])
    {
        return $this->fetch("/payments/".$this->getAppId($appId)."/registerUrls", 'GET', $payload);
    }

    /**
     * @param       $appId
     * @param  array  $payload
     *
     * @return Transaction
     * @throws \Exception
     * @throws \GuzzleHttp\GuzzleException
     */
    public function requestPayment($appId, array $payload = [])
    {
        return $this->fetch("/payments/".$this->getAppId($appId)."/requestPayment", 'GET', $payload);
    }

    /**
     * @param $rawPayload
     * @param $webhookSecret
     *
     * @return bool
     */
    public function processWebhook(Request $request)
    {
        if ($this->disableVerification) {
            Transaction::buildFromCallback($request->input());
        }

        $webhookConfig = new \Spatie\WebhookClient\WebhookConfig([
            'name'                  => 'salami',
            'signing_secret'        => $this->apiToken,
            'signature_header_name' => 'Signature',
            'signature_validator'   => \Spatie\WebhookClient\SignatureValidator\DefaultSignatureValidator::class,
            'webhook_profile'       => \Spatie\WebhookClient\WebhookProfile\ProcessEverythingWebhookProfile::class,
            'webhook_response'      => \Spatie\WebhookClient\WebhookResponse\DefaultRespondsTo::class,
            'webhook_model'         => \Spatie\WebhookClient\Models\WebhookCall::class,
            'process_webhook_job'   => \Deadan\Salami\Jobs\ProcessPaymentWebhook::class,
        ]);

        (new \Spatie\WebhookClient\WebhookProcessor($request, $webhookConfig))->process();
    }
}
