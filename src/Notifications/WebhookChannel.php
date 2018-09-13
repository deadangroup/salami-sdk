<?php

/**
 * This file is part of the Deadan Group Software Stack
 *
 * (c) James Ngugi <james@deadangroup.com>
 * <code> Make it great! </code>
 *
 */

namespace Deadan\Support\Notifications;

use GuzzleHttp\Client;
use Deadan\Support\Http\GuzzleWithBackoff;
use NotificationChannels\Webhook\WebhookChannel as OriginalChannel;

/**
 * An extension of {@link https://packagist.org/packages/laravel-notification-channels/webhook}
 * to handle webhooks honoring exponential backoff.
 * Replace all instances of WebhookChannel from initial package with this one.
 */
class WebhookChannel extends OriginalChannel
{
    /**
     * @param Client $client maintained for compatibility with parent. Not used.
     */
    public function __construct(Client $client)
    {
        $client = GuzzleWithBackoff::make();
        
        parent::__construct($client);
    }
}
