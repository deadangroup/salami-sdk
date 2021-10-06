<?php

namespace Deadan\Salami\Jobs;

use Deadan\Salami\Transaction;
use Spatie\WebhookClient\ProcessWebhookJob as SpatieProcessWebhookJob;

class ProcessPaymentWebhook extends SpatieProcessWebhookJob
{
    public function handle()
    {
        // $this->webhookCall // contains an instance of `WebhookCall`

        // perform the work here

        $transaction = Transaction::buildFromCallback($this->webhookCall->payload);
    }
}