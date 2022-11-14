<?php

namespace DGL\Salami\SignatureValidator;

use Illuminate\Http\Request;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;
use Spatie\WebhookClient\WebhookConfig;

/**
 *
 */
class NullValidator implements SignatureValidator
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \Spatie\WebhookClient\WebhookConfig  $config
     *
     * @return bool
     */
    public function isValid(Request $request, WebhookConfig $config): bool
    {
        return true;
    }
}
