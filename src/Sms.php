<?php

namespace Deadan\Salami;

use Deadan\Salami\Plugins\SalamiSms;

class Sms
{
    /**
     * @param $to
     * @param $message
     *
     * @return \Deadan\Salami\Dto\SalamiApiResponse|void
     */
    public static function send($to, $message)
    {
        if (is_null($to)) {
            \Log::emergency("$to is not a valid phonenumber");

            return;
        }

        if (config('salami.sms.enabled') == false) {
            \Log::notice("Sending SMS, To:$to, Content:$message ");

            return;
        }

        $salamiSms = (new SalamiSms(config('salami.sms.token')))->withBaseUrl(config('salami.sms.base_url'))
                                                                ->withAppId(config('salami.sms.app_id'));

        $to = fix_phone($to, '254');

        $salamiResponse = $salamiSms->sendRaw($to, $message);

        return $salamiResponse;
    }
}
