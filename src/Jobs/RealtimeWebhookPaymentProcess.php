<?php

namespace Deadan\Salami\Jobs;

use Deadan\Salami\Events\SalamiTransactionProcessed;
use Deadan\Salami\Transaction;
use Illuminate\Http\Request;
use Spatie\WebhookClient\Events\InvalidSignatureEvent;
use Spatie\WebhookClient\ProcessWebhookJob as SpatieProcessWebhookJob;

class RealtimeWebhookPaymentProcess extends QueuedWebhookPaymentProcess
{
    //ensures run right now.
    public $queue = 'sync';
}