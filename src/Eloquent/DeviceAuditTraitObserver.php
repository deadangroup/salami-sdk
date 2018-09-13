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

use Deadan\Devices\DeviceFactory;

class DeviceAuditTraitObserver
{
    /**
     * Model's deleting event hook.
     *
     * @param \Yajra\Auditable\AuditableTrait $model
     */
    public function deleting($model)
    {
        if (!$model->device_id) {
            $model->device_id = $this->getCurrentDevice();
        }
    }

    /**
     * Get authenticated user id depending on model's auth guard.
     *
     * @return int
     */
    protected function getCurrentDevice()
    {
        $device = app(DeviceFactory::class)->getSessionDevice();

        return $device ? $device->id : 0;
    }

    /**
     * Model's deleting event hook.
     *
     * @param \Yajra\Auditable\AuditableTrait $model
     */
    public function updating($model)
    {
        if (!$model->device_id) {
            $model->device_id = $this->getCurrentDevice();
        }
    }

    /**
     * Model's deleting event hook.
     *
     * @param \Yajra\Auditable\AuditableTrait $model
     */
    public function creating($model)
    {
        if (!$model->device_id) {
            $model->device_id = $this->getCurrentDevice();
        }
    }
}