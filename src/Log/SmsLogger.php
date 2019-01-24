<?php

namespace Deadan\Support\Log;

use Monolog\Handler\SamplingHandler;
use Monolog\Logger;

class SmsLogger
{
    /**
     * Create a custom Monolog instance.
     *
     * @param array $config
     *
     * @return \Monolog\Logger
     */
    public function __invoke(array $config)
    {
        $this->config = $config;

        $smsHandler = new DeadanSmsLogHandler(
            $this->config('level'),
            $this->config('bubble')
        );

        //we use a sampling handler to prevent an overflow of messages
        $smsHandler->setFormatter(new SmsFormatter());
        $samplinHandler = new SamplingHandler($smsHandler, 2);

        return new Logger('deadan_sms', [$smsHandler]);
    }

    /**
     * Get the value from the passed in config.
     *
     * @param string $field
     *
     * @return mixed
     */
    private function config(string $field)
    {
        return $this->config[$field] ?? null;
    }
}
