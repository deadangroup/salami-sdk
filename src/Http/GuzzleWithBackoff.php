<?php

/**
 * This file is part of the Deadan Group Software Stack
 *
 * (c) James Ngugi <james@deadangroup.com>
 * <code> Make it great! </code>
 *
 */

namespace Deadan\Support\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;

/**
 * Executing GuzzleHttp calls with exponential backoff
 */
class GuzzleWithBackoff
{
    /**
     * @return \GuzzleHttp\Client
     */
    public static function make()
    {
        $stack = HandlerStack::create();

        $stack->push(Middleware::mapRequest(function (RequestInterface $request) {

            return $request
                ->withHeader('App-Version', config('general.app.version'))
                ->withHeader('User-Agent', config('general.webhooks.user_agent'));
        }));

        $stack->push(Middleware::retry(static::retryDecider(), static::retryDelay()));
        return new Client(['handler' => $stack]);
    }

    /**
     * @return \Closure
     */
    public static function retryDecider()
    {
        return function (
            $retries,
            RequestInterface $request,
            Response $response = null,
            RequestException $exception = null
        ) {
            // Limit the number of retries to 5
            if ($retries >= 5) {
                return false;
            }

            // Retry connection exceptions
            if ($exception instanceof ConnectException) {
                return true;
            }

            if ($response) {
                // Retry on server errors
                if ($response->getStatusCode() >= 500) {
                    return true;
                }
            }

            return false;
        };
    }

    /**
     * delay 1s 2s 3s 4s 5s
     *
     * @return \Closure
     */
    public static function retryDelay()
    {
        return function ($numberOfRetries) {
            return 1000 * $numberOfRetries;
        };
    }
}
