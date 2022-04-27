<?php

namespace Deadan\Salami\Events;

use Deadan\Salami\Dto\SalamiApiResponse;

class SalamiApiResponseProcessed
{
    /**
     * @var \Deadan\Salami\Dto\SalamiApiResponse
     */
    public $salamiApiResponse;

    /**
     * @var string
     */
    public $context;

    /**
     * @param  \Deadan\Salami\Dto\SalamiApiResponse  $salamiApiResponse
     * @param $context
     */
    public function __construct(SalamiApiResponse $salamiApiResponse, $context)
    {
        $this->salamiApiResponse = $salamiApiResponse;
        $this->context = $context;
    }

    /**
     * @return \Deadan\Salami\Dto\SalamiApiResponse
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
