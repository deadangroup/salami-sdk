<?php

/*
 *
 *  This is file is part of DGL's tech stack.
 *
 *  @copyright (c) 2024, Deadan Group Limited (DGL).
 *  @link https://www.dgl.co.ke/apps
 *  All rights reserved.
 *
 *  <code>Build something people want!</code>
 */

return [
    // Todo move this to config/services.php file.
    'sms' => [
        'token'    => env('SALAMI_SMS_API_TOKEN'),
        'app_id'   => env('SALAMI_SMS_APP_ID'),
        'base_url' => env('SALAMI_SMS_BASE_URL'),
        //If not enabled, sms will be entered in the log file
        'enabled'  => env('SALAMI_SMS_ENABLED', true),
    ],

    // Todo move this to config/services.php file.
    'pay' => [
        'token'          => env('SALAMI_PAY_API_TOKEN'),
        'app_id'         => env('SALAMI_PAY_APP_ID'),
        'base_url'       => env('SALAMI_PAY_BASE_URL'),
        'webhook_secret' => env('SALAMI_PAY_WEBHOOK_SECRET'),
        'verify'         => env('SALAMI_VERIFY_TRANSACTIONS', true),
    ],
];
