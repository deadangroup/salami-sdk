<?php

/**
 * This file is part of the Deadan Group Software Stack
 *
 * (c) James Ngugi <james@deadangroup.com>
 * <code> Make it great! </code>
 *
 */

namespace Deadan\Support\Validation;

use RuntimeException;

class PhoneNumberRegexRule
{
    /**
     * The name of the rule.
     */
    protected $rule = 'phonenumber';
    
    /**
     * @var array
     */
    protected $regex = [
        'saf_ke'    => "/(\+?254|0|^){1}[-. ]?[7]{1}([0-2]{1}[0-9]{1}|[9]{1}[0-2]{1})[0-9]{6}\z/",
        'airtel_ke' => "/(\+254|0|^){1}[-. ]?[7]{1}([3]{1}[0-9]{1}|[8]{1}[5-9])[0-9]{6}\z/",
    ];
    
    /**
     * The mno currently being validated
     *
     * @type string
     */
    protected $mno;
    
    /**
     * @param $mno string mobile network operator whose number we want to validate
     *
     * @return $this
     */
    public function mno($mno)
    {
        if (!array_key_exists($mno, $this->regex)) {
            throw new RuntimeException("No validation regex available for {$mno} phonenumbers");
        }
        
        $this->mno = $mno;
        
        return $this;
    }
    
    /**
     * Convert the rule to a validation string.
     *
     * @return string
     */
    public function __toString()
    {
        if (!is_null($this->mno)) {
            return 'regex:' . $this->regex[$this->mno];
        }
        
        return '';
    }
}
