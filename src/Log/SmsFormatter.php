<?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Deadan\Support\Log;

use Monolog\Formatter\FormatterInterface;

/**
 * Class SmsFormatter
 * @package Deadan\Support\Log
 */
class SmsFormatter implements FormatterInterface
{
    public function format(array $record)
    {
        $tag = config('app.name') . ' ' . $record['level_name'] . '(' . $record['datetime']->format("Y-m-d/H:i:s") . ') ::' . $record['message'];
        return $tag;
    }

    public function formatBatch(array $records)
    {
        $message = '';
        foreach ($records as $record) {
            $message .= $this->format($record);
        }

        return $message;
    }
}
