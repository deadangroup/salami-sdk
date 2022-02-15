<?php

namespace Deadan\Salami\Jobs;

use Deadan\Salami\Events\SalamiTransactionProcessed;
use Deadan\Salami\Transaction;
use Illuminate\Http\Request;
use Spatie\WebhookClient\ProcessWebhookJob as SpatieProcessWebhookJob;

class QueuedWebhookPaymentProcess extends SpatieProcessWebhookJob
{
    public function handle()
    {
        // $this->webhookCall // contains an instance of `WebhookCall`

        // perform the work here
        $transaction = Transaction::buildFromCallback($this->webhookCall->payload);
        event(new SalamiTransactionProcessed($transaction, $this->webhookCall->name));
    }
}