<?php
/*
 *
 *  This is file is part of DGL's tech stack.
 *
 *  @copyright (c) 2024, Deadan Group Limited (DGL).
 *  @link https://www.dgl.co.ke/products
 *  All rights reserved.
 *
 *  <code>Build something people want!</code>
 */

namespace DGL\Salami\Jobs;

/**
 *
 */
class RealtimeSalamiApiResponseProcess extends QueuedSalamiApiResponseProcess
{
    //ensures run right now.
    /**
     * @var string
     */
    public $queue = 'sync';
}