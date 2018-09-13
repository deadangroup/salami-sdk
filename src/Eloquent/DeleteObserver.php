<?php

namespace Deadan\Support\Eloquent;

class DeleteObserver
{
    /**
     * Model's deleting event hook.
     *
     * @param \Yajra\Auditable\AuditableTrait $model
     */
    public function deleting($model)
    {
        if (!$model->deleted_by) {
            $model->deleted_by = $this->getAuthenticatedUserId();
        }
    }
    
    /**
     * Get authenticated user id depending on model's auth guard.
     *
     * @return int
     */
    protected function getAuthenticatedUserId()
    {
        return auth()->check() ? auth()->id() : 0;
    }
}
