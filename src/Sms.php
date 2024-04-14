<?php

namespace DGL\Salami;

use DGL\Salami\Plugins\SalamiSms;
use Log;

/**
 *
 */
class Sms
{
    /**
     * @param $to
     * @param $message
     *
     * @return \DGL\Salami\Dto\SalamiApiResponse|void
     */
    public static function send($to, $message)
    {
        if (config('salami.sms.enabled') == false) {
            Log::notice("Sending SMS, To:$to, Content:$message ");

            return;
        }

        $salamiSms = (new SalamiSms(config('salami.sms.token')))
            ->withBaseUrl(config('salami.sms.base_url'))
            ->withAppId(config('salami.sms.app_id'));

        return $salamiSms->sendRaw($to, $message);
    }
}
