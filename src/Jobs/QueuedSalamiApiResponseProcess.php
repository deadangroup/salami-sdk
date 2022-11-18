<?php

namespace DGL\Salami\Jobs;

use DGL\Salami\Dto\SalamiApiResponse;
use DGL\Salami\Events\SalamiApiResponseProcessed;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob as SpatieProcessWebhookJob;

/**
 *
 */
class QueuedSalamiApiResponseProcess extends SpatieProcessWebhookJob
{
    /**
     * @return void
     */
    public function handle()
    {
        // $this->webhookCall // contains an instance of `WebhookCall`

        // perform the work here
        $SalamiApiResponse = SalamiApiResponse::buildFromCallback($this->webhookCall->payload);
        event(new SalamiApiResponseProcessed($SalamiApiResponse, $this->webhookCall->name));
    }
}