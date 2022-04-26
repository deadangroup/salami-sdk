<?php

namespace Deadan\Salami\Events;

use Deadan\Salami\SalamiApiResponse;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SalamiSmsProcessed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var array
     */
    public $salamiData;

    /**
     * SalamiApiResponseProcessed constructor.
     *
     * @param  \Deadan\Salami\SalamiApiResponse $salamiData
     */
    public function __construct($salamiData=[])
    {
        $this->salamiData = $salamiData;
    }
}
