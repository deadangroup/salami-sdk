<?php

namespace Deadan\Salami\Events;

use Deadan\Salami\SalamiApiResponse;

class SalamiApiResponseProcessed
{
    /**
     * @var \Deadan\Salami\SalamiApiResponse
     */
    public $salamiApiResponse;

    /**
     * @var string
     */
    public $context;

    /**
     * @param  \Deadan\Salami\SalamiApiResponse  $salamiApiResponse
     * @param $context
     */
    public function __construct(SalamiApiResponse $salamiApiResponse, $context)
    {
        $this->salamiApiResponse = $salamiApiResponse;
        $this->context = $context;
    }

    /**
     * @return \Deadan\Salami\SalamiApiResponse
     */
    public function getSalamiApiResponse()
    {
        return $this->salamiApiResponse;
    }

    /**
     * @return string
     */
    public function getContext()
    {
        return $this->context;
    }
}
