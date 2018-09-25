<?php

/**
 * This file is part of the Deadan Group Software Stack
 *
 * (c) James Ngugi <james@deadangroup.com>
 * <code> Make it great! </code>
 *
 */

namespace Deadan\Support\Eloquent;

use Hashids;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class UuidTraitObserver
{
    /**
     * Model's created event hook.
     *
     * @param Model $model
     * @throws \Exception
     */
    public function created(Model $model)
    {
        $columnName = $model->getUuidColumn();

        //if the field has not been populated, populate it
        if (!$model->{$columnName}) {
            //if model explicitly requests for UUID4, use it
            if ($model->useUuid4) {
                $token = Uuid::uuid4()->toString();
            } else {
                $token = Hashids::encode($model->id);

                $classPrefix = substr(get_class($model), 0, 2);
                $token = strtoupper($classPrefix) . $token;
            }

            $model->{$columnName} = $token;
            $model->save();
        }
    }
}
