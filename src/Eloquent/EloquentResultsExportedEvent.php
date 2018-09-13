<?php
/**
 * This file is part of the Deadan Group Software Stack
 *
 * (c) James Ngugi <james@deadangroup.com>
 *
 * <code> Build something people want </code>
 *
 */

namespace Deadan\Support\Eloquent;

use Deadan\Analytics\Contracts\Trackable;
use Deadan\Analytics\Traits\TrackableTrait;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EloquentResultsExportedEvent implements Trackable
{
    use Dispatchable, InteractsWithSockets, SerializesModels, TrackableTrait;

    /**
     * @var
     */
    public $filename;
    /**
     * @var
     */
    public $exportType;

    /**
     * EloquentResultsExportedEvent constructor.
     *
     * @param $filename
     * @param $exportType
     */
    public function __construct($filename, $exportType)
    {
        $this->filename = $filename;
        $this->exportType = $exportType;
    }

    /**
     * @return array
     */
    public function getTrackingData(): array
    {
        return [
            'filename'   => $this->filename,
            'exportType' => $this->exportType,
        ];
    }
}