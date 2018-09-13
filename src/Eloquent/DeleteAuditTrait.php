<?php
/**
 * This file is part of the Deadan Group Software Stack
 *
 * (c) James Ngugi <ngugiwjames@gmail.com>
 *
 * <code> Build something people want </code>
 *
 */

namespace Deadan\Support\Eloquent;

trait DeleteAuditTrait
{
    /**
     * Boot the audit trait for a model.
     *
     * @return void
     */
    public static function bootDeleteAuditTrait()
    {
        static::observe(new DeleteObserver);
    }

    /**
     * Get user model who created the record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deletor()
    {
        return $this->belongsTo($this->getUserInstance(), $this->getDeletedByColumn());
    }

    /**
     * Get column name for created by.
     *
     * @return string
     */
    protected function getDeletedByColumn()
    {
        return 'deleted_by';
    }

    /**
     * Get updated by user full name.
     *
     * @return string
     */
    public function getDeletedByNameAttribute()
    {
        if ($this->{$this->getDeletedByColumn()}) {
            return $this->deletor->name;
        }

        return '';
    }
}
