<?php

/**
 * This file is part of the Deadan Group Software Stack
 *
 * (c) James Ngugi <james@deadangroup.com>
 * <code> Make it great! </code>
 *
 */

namespace Deadan\Support\Eloquent;

trait UsesUuidTrait
{
    /**
     * Boot the audit trait for a model.
     *
     * @return void
     */
    public static function bootUsesUuidTrait()
    {
        static::observe(new UuidTraitObserver);
    }
    
    /**
     * Defines the UUID field for the model.
     *
     * @return string
     */
    public function getUuidColumn()
    {
        return 'uuid';
    }
    
    /**
     * Get the route key for the model.
     * This is used to load model from db for route model binding
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
