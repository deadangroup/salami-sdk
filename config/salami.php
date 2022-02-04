<?php

return [
    //general
    'signature_verification' => env('SALAMI_VERIFY_SIGNATURES', true),

    //payments
    'pay_webhook_secret' => env('SALAMI_PAY_WEBHOOK_SECRET'),
    'pay_api_token' => env('SALAMI_PAY_API_TOKEN'),
    'pay_app_id' => env('SALAMI_PAY_APP'),

    //sms
    'sms_webhook_secret' => env('SALAMI_SMS_WEBHOOK_SECRET'),
    'sms_api_token' => env('SALAMI_SMS_API_TOKEN'),
    'sms_app_id' => env('SALAMI_SMS_APP'),
];
