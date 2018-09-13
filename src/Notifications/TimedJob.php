<?php

/**
 * This file is part of the Deadan Group Software Stack
 *
 * (c) James Ngugi <james@deadangroup.com>
 *
 * <code> Build something people want </code>
 *
 */

namespace Deadan\Support\Notifications;

trait TimedJob
{
    /**
     * @var int
     */
    public $maxTries = 5;
    
    /**
     * @var int
     */
    public $tries = 5;
}