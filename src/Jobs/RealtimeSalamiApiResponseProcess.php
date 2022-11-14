<?php

namespace DGL\Salami\Jobs;

/**
 *
 */
class RealtimeSalamiApiResponseProcess extends QueuedSalamiApiResponseProcess
{
    //ensures run right now.
    /**
     * @var string
     */
    public $queue = 'sync';
}