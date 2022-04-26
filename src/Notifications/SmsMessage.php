<?php

namespace Deadan\Salami\Notifications;

use Exception;

class SmsMessage
{
    /**
     * @var
     */
    protected $to;

    /**
     * @var array
     */
    protected $lines = [];

    /**
     * SmsMessage constructor.
     *
     * @param  array  $lines
     */
    public function __construct(array $lines = [])
    {
        $this->lines = $lines;
    }

    /**
     * @param $line
     *
     * @return $this
     */
    public function line($line = ''): self
    {
        $this->lines[] = $line.PHP_EOL;

        return $this;
    }

    /**
     * @param $to
     *
     * @return $this
     */
    public function to($to): self
    {
        $this->to = $to;

        return $this;
    }

    /**
     * @return \Deadan\Salami\SalamiApiResponse|void
     * @throws \Exception
     */
    public function send()
    {
        if (! count($this->lines)) {
            throw new Exception('SMS cannot be empty.');
        }

        return Sms::send($this->to, join(PHP_EOL, $this->lines));
    }
}
