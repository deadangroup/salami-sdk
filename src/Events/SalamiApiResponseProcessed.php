<?php

namespace DGL\Salami\Events;

use DGL\Salami\Dto\SalamiApiResponse;

/**
 *
 */
class SalamiApiResponseProcessed
{
    /**
     * @var \DGL\Salami\Dto\SalamiApiResponse
     */
    public $salamiApiResponse;

    /**
     * @var string
     */
    public $context;

    /**
     * @param  \DGL\Salami\Dto\SalamiApiResponse  $salamiApiResponse
     * @param $context
     */
    public function __construct(SalamiApiResponse $salamiApiResponse, $context)
    {
        $this->salamiApiResponse = $salamiApiResponse;
        $this->context = $context;
    }

    /**
     * @return \DGL\Salami\Dto\SalamiApiResponse
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
