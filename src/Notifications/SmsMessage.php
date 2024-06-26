<?php
/*
 *
 *  This is file is part of DGL's tech stack.
 *
 *  @copyright (c) 2024, Deadan Group Limited (DGL).
 *  @link https://www.dgl.co.ke/apps
 *  All rights reserved.
 *
 *  <code>Build something people want!</code>
 */

namespace DGL\Salami\Notifications;

use Exception;

/**
 *
 */
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
        $this->lines[] = $line;

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
     * @return string
     * @throws \Exception
     */
    public function __toString()
    {
        if (! count($this->lines)) {
            throw new Exception('SMS content cannot be empty.');
        }

        return join(PHP_EOL, $this->lines);
    }
}
