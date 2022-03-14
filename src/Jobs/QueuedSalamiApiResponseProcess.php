<?php

namespace Deadan\Salami\Jobs;

use Deadan\Salami\Events\SalamiApiResponseProcessed;
use Deadan\Salami\SalamiApiResponse;
use Illuminate\Http\Request;
use Spatie\WebhookClient\ProcessWebhookJob as SpatieProcessWebhookJob;

class QueuedSalamiApiResponseProcess extends SpatieProcessWebhookJob
{
    public function handle()
    {
        // $this->webhookCall // contains an instance of `WebhookCall`

        // perform the work here
        $SalamiApiResponse = SalamiApiResponse::buildFromCallback($this->webhookCall->payload);
        event(new SalamiApiResponseProcessed($SalamiApiResponse, $this->webhookCall->name));
    }
}