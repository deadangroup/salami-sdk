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
     * @return \Deadan\Salami\SalamiApiResponse
     * @throws \Exception
     */
    public function querySalamiApiResponses(array $payload = [])
    {
        return $this->call("/payments/".$this->getAppId()."/querySalamiApiResponses", 'GET', $payload);
    }

    /**
     * @param $SalamiApiResponseId
     * @return \Deadan\Salami\SalamiApiResponse
     * @throws \Exception
     */
    public function getSalamiApiResponse($SalamiApiResponseId)
    {
        return $this->call("/payments/".$this->getAppId()."/SalamiApiResponse/".$SalamiApiResponseId, 'GET');
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
    public function extractSalamiApiResponse(array $payload = [])
    {
        return $this->call("/payments/".$this->getAppId()."/extractSalamiApiResponse", 'GET', $payload);
    }

    /**
     * @param  array  $payload
     * @return \Deadan\Salami\SalamiApiResponse
     * @throws \Exception
     */
    public function fetchSalamiApiResponses(array $payload = [])
    {
        return $this->call("/payments/".$this->getAppId()."/fetchSalamiApiResponses", 'GET', $payload);
    }

    /**
     * @param $SalamiApiResponseId
     * @return \Deadan\Salami\SalamiApiResponse
     * @throws \Exception
     */
    public function getSalamiApiResponseStatus($SalamiApiResponseId)
    {
        return $this->call("/payments/".$this->getAppId()."/getSalamiApiResponseStatus/".$SalamiApiResponseId, 'GET');
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
            'process_webhook_job'   => \Deadan\Salami\Jobs\ProcessSalamiSalamiApiResponse::class,
        ]);

        return (new \Spatie\WebhookClient\WebhookProcessor($request, $webhookConfig))->process();
    }
}
