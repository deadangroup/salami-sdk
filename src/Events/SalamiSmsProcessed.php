<?php

namespace Deadan\Salami\Events;

use Deadan\Salami\SalamiApiResponse;

class SalamiSmsProcessed
{
    /**
     * @var \Deadan\Salami\SalamiApiResponse
     */
    public $salamiApiResponse;

    /**
     * SalamiApiResponseProcessed constructor.
     *
     * @param  \Deadan\Salami\SalamiApiResponse $salamiApiResponse
     */
    public function __construct(SalamiApiResponse $salamiApiResponse)
    {
        $this->salamiApiResponse = $salamiApiResponse;
    }

    /**
     * @return \Deadan\Salami\SalamiApiResponse
     */
    public function getSalamiApiResponse()
    {
        return $this->salamiApiResponse;
    }
}
