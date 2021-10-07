<?php

return [
    'pay_api_token'          => env('SALAMI_PAY_API_TOKEN'),
    'sms_api_token'          => env('SALAMI_SMS_API_TOKEN'),
    'signature_verification' => env('SALAMI_VERIFY_SIGNATURES', true),
    'sms_app_id'             => env('SALAMI_SMS_APP'),
    'pay_app_id'             => env('SALAMI_PAY_APP'),
];
