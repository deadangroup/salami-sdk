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
    if (begins_with($number, '+')) {
        $number = substr($number, 1);
    } elseif (begins_with($number, '07')) {
        $number = $country_code.substr($number, 1);
    } elseif (begins_with($number, '7')) {
        $number = $country_code.$number;
    }

    return $number;
}

if (!function_exists('begins_with')) {
    /**
     * Determine if a given string starts with a given substring.
     *
     * @param  string  $haystack
     * @param  string  $needle
     * @return bool
     */
    function begins_with($haystack, $needle)
    {
        if ((string) $needle !== '' && strncmp($haystack, $needle, strlen($needle)) === 0) {
            return true;
        }

        return false;
    }
}