<?php

/**
 *
 * (c) www.deadangroup.com
 *
 * <code> Build something people want </code>
 *
 */

namespace Deadan\Salami\Plugins;

use Deadan\Salami\Jobs\ProcessPaymentWebhook;
use Illuminate\Http\Request;

/**
 * Class SalamiPay
 *
 * @package Deadan\Salami\Plugins
 */
class SalamiPay extends BaseSdk
{
    /**
     * @param  array  $payload
     * @return \Deadan\Salami\Transaction
     * @throws \Exception
     */
    public function queryTransactions(array $payload = [])
    {
        return $this->call("/payments/".$this->getAppId()."/queryTransactions", 'GET', $payload);
    }

    /**
     * @param $transactionId
     * @return \Deadan\Salami\Transaction
     * @throws \Exception
     */
    public function getTransaction($transactionId)
    {
        return $this->call("/payments/".$this->getAppId()."/transaction/".$transactionId, 'GET');
    }

    /**
     * @param  array  $payload
     * @return \Deadan\Salami\Transaction
     * @throws \Exception
     */
    public function checkBalance(array $payload = [])
    {
        return $this->call("/payments/".$this->getAppId()."/checkBalance", 'GET', $payload);
    }

    /**
     * @param  array  $payload
     * @return \Deadan\Salami\Transaction
     * @throws \Exception
     */
    public function extractTransaction(array $payload = [])
    {
        return $this->call("/payments/".$this->getAppId()."/extractTransaction", 'GET', $payload);
    }

    /**
     * @param  array  $payload
     * @return \Deadan\Salami\Transaction
     * @throws \Exception
     */
    public function fetchTransactions(array $payload = [])
    {
        return $this->call("/payments/".$this->getAppId()."/fetchTransactions", 'GET', $payload);
    }

    /**
     * @param $transactionId
     * @return \Deadan\Salami\Transaction
     * @throws \Exception
     */
    public function getTransactionStatus($transactionId)
    {
        return $this->call("/payments/".$this->getAppId()."/getTransactionStatus/".$transactionId, 'GET');
    }

    /**
     * @param  array  $payload
     * @return \Deadan\Salami\Transaction
     * @throws \Exception
     */
    public function registerUrls(array $payload = [])
    {
        return $this->call("/payments/".$this->getAppId()."/registerUrls", 'GET', $payload);
    }

    /**
     * @param  array  $payload
     * @return \Deadan\Salami\Transaction
     * @throws \Exception
     */
    public function requestPayment(array $payload = [])
    {
        return $this->call("/payments/".$this->getAppId()."/requestPayment", 'GET', $payload);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Spatie\WebhookClient\Exceptions\InvalidConfig
     */
    public function processWebhook(Request $request)
    {
        if ($this->signatureVerification == true) {
            $validator = \Spatie\WebhookClient\SignatureValidator\DefaultSignatureValidator::class;
        } else {
            $validator = \Deadan\Salami\SignatureValidator\NullValidator::class;
        }

        if (class_exists(\Stancl\Tenancy\Tenancy::class) && !is_null(tenant('id'))) {
            $name = 'salami_tenant_'.tenant('id');
        } else {
            $name = 'salami_no_tenant';
        }

        $webhookConfig = new \Spatie\WebhookClient\WebhookConfig([
            'name'                  => $name,
            'signing_secret'        => $this->webhookSecret,
            'signature_header_name' => $this->signatureHeaderName,
            'signature_validator'   => $validator,
            'webhook_profile'       => \Spatie\WebhookClient\WebhookProfile\ProcessEverythingWebhookProfile::class,
            'webhook_response'      => \Spatie\WebhookClient\WebhookResponse\DefaultRespondsTo::class,
            'webhook_model'         => \Spatie\WebhookClient\Models\WebhookCall::class,
            'process_webhook_job'   => \Deadan\Salami\Jobs\ProcessSalamiPaymentWebhook::class,
        ]);

        return (new \Spatie\WebhookClient\WebhookProcessor($request, $webhookConfig))->process();
    }
}
