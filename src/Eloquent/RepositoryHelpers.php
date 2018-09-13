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

trait RepositoryHelpers
{
    /**
     * Handle dynamic method calls into the model.
     *
     * @param  string $method
     * @param  array  $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        $this->applyCriteria();
        
        //todo this does not always work as expected
        return $this->model->$method(...$parameters);
    }
    
    /**
     * @return $this
     */
    public function popAllCriteria()
    {
        $criteria = $this->getCriteria();
        
        foreach ($criteria->toArray() as $criteria) {
            
            $this->popCriteria($criteria);
        }
        
        return $this;
    }
}