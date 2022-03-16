<?php

namespace Deadan\Salami\Events;

use Deadan\Salami\SalamiApiResponse;
use Illuminate\Queue\SerializesModels;

class SalamiApiResponseProcessed
{
    use SerializesModels;

    /**
     * @var \Deadan\Salami\SalamiApiResponse
     */
    public $salamiApiResponse;

    /**
     * @var string
     */
    public $context;

    /**
     * SalamiApiResponseProcessed constructor.
     *
     * @param  \Deadan\Salami\SalamiApiResponse $salamiApiResponse
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
