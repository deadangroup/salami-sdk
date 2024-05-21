<?php
/*
 *
 *  This is file is part of DGL's tech stack.
 *
 *  @copyright (c) 2024, Deadan Group Limited (DGL).
 *  @link https://www.dgl.co.ke/products
 *  All rights reserved.
 *
 *  <code>Build something people want!</code>
 */

namespace DGL\Salami;

use DGL\Salami\Plugins\SalamiPay;

/**
 *
 */
class Pay
{
    /**
     * @return \DGL\Salami\Plugins\SalamiPay
     */
    public static function init()
    {
        $salamiPay = (new SalamiPay(config('salami.pay.token')))->withBaseUrl(config('salami.pay.base_url'))
            ->withWebhookSecret(config('salami.pay.webhook_secret'))
            ->setSignatureVerification(config('salami.pay.verify'));

        return $salamiPay;
    }
}