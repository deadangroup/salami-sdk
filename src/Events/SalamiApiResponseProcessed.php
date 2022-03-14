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
    public $SalamiApiResponse;

    /**
     * @var string
     */
    public $context;

    /**
     * SalamiApiResponseProcessed constructor.
     *
     * @param  \Deadan\Salami\SalamiApiResponse $SalamiApiResponse
     */
    public function __construct(SalamiApiResponse $SalamiApiResponse, $context)
    {
        $this->SalamiApiResponse = $SalamiApiResponse;
        $this->context = $context;
    }

    /**
     * @return \Deadan\Salami\SalamiApiResponse
     */
    public function getSalamiApiResponse()
    {
        return $this->SalamiApiResponse;
    }

    /**
     * @return string
     */
    public function getContext()
    {
        return $this->context;
    }
}
