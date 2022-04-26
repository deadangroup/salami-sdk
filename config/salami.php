<?php

/*
 * @copyright Deadan Group Limited
 * <code> Build something people want </code>
 */

return [
    // Add this to the config/services.php file.
    'sms' => [
        'token'    => env('SALAMI_SMS_API_TOKEN'),
        'app_id'   => env('SALAMI_SMS_APP_ID'),
        'base_url' => env('SALAMI_SMS_BASE_URL'),
    ],

    // Add this to the config/services.php file.
    'pay' => [
        'token'          => env('SALAMI_PAY_API_TOKEN'),
        'app_id'         => env('SALAMI_PAY_APP_ID'),
        'base_url'       => env('SALAMI_PAY_BASE_URL'),
        'webhook_secret' => env('SALAMI_PAY_WEBHOOK_SECRET'),
        'verify'         => env('SALAMI_VERIFY_TRANSACTIONS'),
    ],
];
