<?php

namespace Deadan\Salami;

use Deadan\Salami\Plugins\SalamiPay;

class Pay
{
    public static function init()
    {
        $salamiPay = (new SalamiPay(config('salami.pay.token')))->withBaseUrl(config('salami.pay.base_url'))
                                                                ->withWebhookSecret(config('salami.pay.webhook_secret'))
                                                                ->setSignatureVerification(config('salami.pay.verify'));

        return $salamiPay;
    }
}