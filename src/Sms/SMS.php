<?php

/**
 * This file is part of the Deadan Group Software Stack
 *
 * (c) James Ngugi <james@deadangroup.com>
 *
 * <code> Build something people want </code>
 *
 */

namespace Deadan\Support\Sms;

class SMS
{
    /**
     * @var Factory
     */
    public $smsFactory = null;

    /**
     * @param $config
     * @return Factory
     */
    public function __construct($config)
    {
        if (!is_null($this->smsFactory)) {
            return $this->smsFactory;
        }

        $factory = with(new Factory())
            ->withBaseEndpoint($config['baseEndpoint'])
            ->withOauthClientId($config['oauthClientId'])
            ->withOauthClientSecret($config['oauthClientSecret'])
            ->withVersion($config['version']);

        return $this->smsFactory = $factory;
    }

    /**
     * Pass any methods we don't recognize to the Parent Factory instance.
     *
     * @param  string $method
     * @param  array $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        $config = config('deadan_support.sms');
        if ($config && array_key_exists('oauthClientId', $config) && array_key_exists('oauthClientSecret', $config)) {
            return (new static($config))->smsFactory->$method(...$parameters);
        }
        return null;
    }

    /**
     * Pass any methods we don't recognize to the Parent Factory instance.
     *
     * @param  string $method
     * @param  array $parameters
     *
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        $config = config('deadan_support.sms');
        if ($config && array_key_exists('oauthClientId', $config) && array_key_exists('oauthClientSecret', $config)) {
            return (new static($config))->smsFactory->$method(...$parameters);
        }
        return null;
    }
}