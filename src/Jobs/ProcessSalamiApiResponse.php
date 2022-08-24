<?php

namespace Deadan\Salami\Jobs;

use Deadan\Salami\Dto\SalamiApiResponse;
use Deadan\Salami\Events\SalamiApiResponseProcessed;
use Illuminate\Http\Request;
use Spatie\WebhookClient\ProcessWebhookJob as SpatieProcessWebhookJob;

class ProcessSalamiApiResponse extends SpatieProcessWebhookJob
{
    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'salami_sdk_module';

    public function handle()
    {
        // $this->webhookCall // contains an instance of `WebhookCall`

        // perform the work here
        $SalamiApiResponse = SalamiApiResponse::buildFromCallback($this->webhookCall->payload);
        event(new SalamiApiResponseProcessed($SalamiApiResponse, $this->webhookCall->name));
    }
}