<?php
/**
 * This file is part of the Deadan Group Software Stack
 *
 * (c) James Ngugi <james@deadangroup.com>
 *
 * <code> Build something people want </code>
 *
 */

namespace Deadan\Support\Eloquent;

use Deadan\Devices\Models\Device;

trait DeviceAuditTrait
{
    /**
     * Boot the audit trait for a model.
     *
     * @return void
     */
    public static function bootDeviceAuditTrait()
    {
        static::observe(new DeviceAuditTraitObserver);
    }
    
    /**
     * Get user model who created the record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function device()
    {
        return $this->belongsTo(Device::class, $this->getDeviceIdColumn());
    }
    
    /**
     * Get column name for created by.
     *
     * @return string
     */
    protected function getDeviceIdColumn()
    {
        return 'device_id';
    }
}