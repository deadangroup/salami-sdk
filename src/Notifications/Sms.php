<?php

namespace Deadan\Salami\Notifications;

use Deadan\Salami\Plugins\SalamiSms;

class Sms
{
    /**
     * @param $to
     * @param $message
     *
     * @return \Deadan\Salami\SalamiApiResponse|void
     */
    public static function send($to, $message, $config = [])
    {
        if (is_null($to)) {
            \Log::emergency("$to is not a valid phonenumber");

            return;
        }

        $salamiSms = (new SalamiSms(config('salami.sms.token')))->withBaseUrl(config('salami.sms.base_url'))
                                                                ->withAppId(config('salami.sms.app_id'));

        $to = fix_phone($to, '254');

        try {
            $salamiResponse = $salamiSms->sendRaw($to, $message);

            return $salamiResponse;
        } catch (\Exception $e) {
            \Log::emergency('File:'.$e->getFile().' Line:'.$e->getLine().' Message:'.$e->getMessage().' Trace:'.$e->getTraceAsString());
        }
    }
}
