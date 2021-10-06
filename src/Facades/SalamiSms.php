<?php

namespace Deadan\Salami\Facades;

use Illuminate\Support\Facades\Facade;

class SalamiSms extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'salami_sms';
    }
}
