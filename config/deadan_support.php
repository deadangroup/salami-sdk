<?php

/**
 * This file is part of the Deadan Group Software Stack
 *
 * (c) James Ngugi <james@deadangroup.com>
 *
 * <code> Build something people want </code>
 *
 */

return [
    'sms' => [
        'baseEndpoint' => 'http://sms.deadangroup.com',
        'version'      => '',//e.g v1
        'appId'        => '1',//e.g 1
        //your personal access token from http://sms.deadangroup.com/api/personal-tokens
        "accessToken"  => file_get_contents(__DIR__ . '/personal_token.txt'),
        "httpErrors"  => false,//show Guzzlehttp errors?
    ],
];