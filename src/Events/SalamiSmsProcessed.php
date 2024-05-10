<?php
/*
 *
 *  This is file is part of DGL's tech stack.
 *
 *  @copyright (c) 2024, Deadan Group Limited (DGL).
 *  @link https://www.dgl.co.ke/products
 *  All rights reserved.
 *
 *  <code>Build something people want!</code>
 */

namespace DGL\Salami\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 *
 */
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
     * @param \DGL\Salami\Dto\SalamiApiResponse $salamiData
     */
    public function __construct($salamiData = [])
    {
        $this->salamiData = $salamiData;
    }
}
