<?php

namespace Deadan\Salami\Jobs;

use Illuminate\Http\Request;

class RealtimeWebhookPaymentProcess extends QueuedWebhookPaymentProcess
{
    //ensures run right now.
    public $queue = 'sync';
}