<?php

/**
 * This file is part of the Deadan Group Software Stack
 *
 * (c) James Ngugi <james@deadangroup.com>
 * <code> Make it great! </code>
 *
 */

namespace Deadan\Support\Str;

class Mask
{
    /**
     * Method masks the username of an email address
     *
     * @param string $email the email address to mask
     *
     * @return string
     */
    public function maskEmail($email)
    {
        list($username, $domain) = preg_split("/@/", $email);
        
        $masked = $this->mask($username, '*', 40);
        
        return ($masked . '@' . $domain);
    }
    
    /**
     * Method masks part of the provided string
     *
     * @param string $string    the string to mask
     * @param string $mask_char the character to use to mask with
     * @param int    $percent   the percent of the string to mask
     *
     * @return string
     */
    public function mask($string, $mask_char = '.', $percent = 50)
    {
        $len = strlen($string);
        
        $mask_count = floor($len * $percent / 100);
        
        $offset = floor(($len - $mask_count) / 2);
        
        $masked = substr($string, 0, $offset)
            . str_repeat($mask_char, $mask_count)
            . substr($string, $mask_count + $offset);
        
        return $masked;
    }
    
    /**
     * Method masks the phone
     *
     * @param string $phone the phonenumber to mask
     *
     * @return string
     */
    public function maskPhone($phone)
    {
        return $this->mask($phone, '*', 40);
    }
}