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

namespace DGL\Salami\Events;

use DGL\Salami\Dto\SalamiApiResponse;

/**
 *
 */
class SalamiApiResponseProcessed
{
    /**
     * @var \DGL\Salami\Dto\SalamiApiResponse
     */
    public $salamiApiResponse;

    /**
     * @var string
     */
    public $name;

    /**
     * @param \DGL\Salami\Dto\SalamiApiResponse $salamiApiResponse
     * @param $name
     */
    public function __construct(SalamiApiResponse $salamiApiResponse, $name)
    {
        $this->salamiApiResponse = $salamiApiResponse;
        $this->name = $name;
    }

    /**
     * @return \DGL\Salami\Dto\SalamiApiResponse
     */
    public function getSalamiApiResponse()
    {
        return $this->salamiApiResponse;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
