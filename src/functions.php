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

/**
 * Fix phonenumber to start with country code.
 *
 * Only tested with african phone numbers.
 *
 * @param $number
 * @param string $country_code
 *
 * @return false|mixed|string
 */
function fix_phone($number, string $country_code = '254')
{
//    if (substr($number, 0, 1) === '+') {
//        $number = substr($number, 1);
//    } elseif (substr($number, 0, 2) === '07') {
//        $number = $country_code.substr($number, 1);
//    } elseif (substr($number, 0, 1) === '7') {
//        $number = $country_code.$number;
//    }
//
//    return $number;

    $phoneLib = new \DGL\Salami\Libs\Phone();

    try {
        # Format phone numbers
        $formatted_number = $phoneLib->formattedPhoneNo($number);

        if ($formatted_number) {
            # Check ISP
            $isp = $phoneLib->checkOperator($formatted_number);

            if ($isp) {
                return $formatted_number;
            }
        }

        return false;
    } catch (Exception $exception) {
        \Log::emergency($exception->getMessage());
        return false;
    }
}