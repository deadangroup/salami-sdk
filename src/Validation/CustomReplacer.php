<?php

/**
 * This file is part of the Deadan Group Software Stack
 *
 * (c) James Ngugi <james@deadangroup.com>
 * <code> Make it great! </code>
 *
 */

namespace Deadan\Support\Validation;

use Illuminate\Validation\Validator;

/**
 * Class CustomReplacer
 * This class is especially helpful for array validations.
 *
 * @package Deadan\Support\Validation
 */
class CustomReplacer extends Validator
{
    /**
     * Replace all place-holders for the email rule.
     *
     * @param  string $message
     * @param  string $attribute
     * @param  string $rule
     * @param  array  $parameters
     *
     * @return string
     */
    protected function replaceEmail($message, $attribute, $rule, $parameters)
    {
        return str_replace(':value', $this->getValue($attribute), $message);
    }
    
    /**
     * Replace all place-holders for the unique rule.
     *
     * @param  string $message
     * @param  string $attribute
     * @param  string $rule
     * @param  array  $parameters
     *
     * @return string
     */
    protected function replaceUnique($message, $attribute, $rule, $parameters)
    {
        return str_replace(':value', $this->getValue($attribute), $message);
    }
    
    /**
     * Replace all place-holders for the exists rule.
     *
     * @param  string $message
     * @param  string $attribute
     * @param  string $rule
     * @param  array  $parameters
     *
     * @return string
     */
    protected function replaceExists($message, $attribute, $rule, $parameters)
    {
        return str_replace(':value', $this->getValue($attribute), $message);
    }
    
    /**
     * Replace all place-holders for the exists rule.
     *
     * @param  string $message
     * @param  string $attribute
     * @param  string $rule
     * @param  array  $parameters
     *
     * @return string
     */
    protected function replaceExcelColumns($message, $attribute, $rule, $parameters)
    {
        return str_replace(':other', implode(",", $parameters), $message);
    }
}