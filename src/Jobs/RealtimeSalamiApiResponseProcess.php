<?php

namespace Deadan\Salami\Jobs;

use Illuminate\Http\Request;

class RealtimeSalamiApiResponseProcess extends QueuedSalamiApiResponseProcess
{
    //ensures run right now.
    public $queue = 'sync';
}