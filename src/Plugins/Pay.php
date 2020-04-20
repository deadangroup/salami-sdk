<?php

/**
 *
 * (c) www.deadangroup.com
 *
 * <code> Build something people want </code>
 *
 */

namespace Deadan\Salami\Plugins;

use Deadan\Salami\Sdk;

class Pay
{
    /**
     * @var \Deadan\Salami\Sdk
     */
    private $sdk;
    
    /**
     * Pay constructor.
     */
    public function __construct(Sdk $sdk)
    {
        $this->sdk = $sdk;
    }
}