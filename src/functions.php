<?php

/*
 * @copyright Deadan Group Limited
 * <code> Build something people want </code>
 */

/**
 * Fix phonenumber to start with country code.
 *
 * Only tested with african phone numbers.
 *
 * @param $number
 * @param $country_code
 * @return false|mixed|string
 */
function fix_phone($number, $country_code)
{

    if (substr( $number, 0, 1 ) === '+') {
        $number = substr($number, 1);
    } elseif (substr( $number, 0, 2 ) === '07') {
        $number = $country_code.substr($number, 1);
    } elseif (substr( $number, 0, 1 ) === '7') {
        $number = $country_code.$number;
    }

    return $number;
}