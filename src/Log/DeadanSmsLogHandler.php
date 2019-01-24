<?php

/**
 * This file is part of the Deadan Group Software Stack
 *
 * (c) James Ngugi <james@deadangroup.com>
 *
 * <code> Build something people want </code>
 *
 */

namespace Deadan\Support\Log;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class DeadanSmsLogHandler extends AbstractProcessingHandler
{
    /**
     * DeadanSmsLogHandler constructor.
     * @param int $level
     * @param bool $bubble
     */
    public function __construct($level = Logger::CRITICAL, $bubble = true)
    {
        parent::__construct($level, $bubble);
    }

    /**
     * {@inheritdoc}
     */
    public function write(array $record)
    {
        $payload = [
            'to'      => config('logging.channels.deadan_sms.to'),
            'message' => $record["level_name"] . "::" . $record["message"],
        ];

        \Log::info("DeadanSmsLogHandler", $record);

        //send it baby!
        app('deadan_sms')->send($payload);
    }
}
