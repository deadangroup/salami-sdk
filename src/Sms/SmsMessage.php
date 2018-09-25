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

class SmsMessage
{
    /**
     * The message content.
     *
     * @var string
     */
    public $content;
    /**
     * Create a new message instance.
     *
     * @param string $content
     */
    public function __construct($content = '')
    {
        $this->content = $content;
    }
    /**
     * Add a line to message content
     *
     * @param $line
     *
     * @return $this
     */
    public function line($line)
    {
        $this->content .= $line . "\n";
        return $this;
    }
    /**
     * @param array $extra
     *
     * @return SmsMessage
     */
    public function setExtra(array $extra): SmsMessage
    {
        $this->extra = $extra;
        return $this;
    }
    /**
     * Gets the The message content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
    /**
     * @param string $content
     *
     * @return SmsMessage
     */
    public function setContent(string $content): SmsMessage
    {
        $this->content = $content;
        return $this;
    }
}