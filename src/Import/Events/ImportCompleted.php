<?php

/**
 * This file is part of the Deadan Group Software Stack
 *
 * (c) James Ngugi <james@deadangroup.com>
 *
 * <code> Build something people want </code>
 *
 */

namespace Deadan\Support\Import\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Deadan\Analytics\Contracts\Trackable;
use Deadan\Analytics\Traits\TrackableTrait;
use Deadan\Support\Import\ImportQueue;

class ImportCompleted implements Trackable
{
    use Dispatchable, InteractsWithSockets, SerializesModels, TrackableTrait;
    
    /**
     * @var \Deadan\Support\Import\ImportQueue
     */
    public $queue;
    
    /**
     * ImportCompleted constructor.
     *
     * @param $queue \Deadan\Support\Import\ImportQueue
     */
    public function __construct(ImportQueue $queue)
    {
        $this->queue = $queue;
    }
    
    /**
     * @return array
     */
    public function getTrackingData(): array
    {
        return [
            'queue' => $this->queue->toArray(),
        ];
    }
}
