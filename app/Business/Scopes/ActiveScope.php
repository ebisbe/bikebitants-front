<?php

namespace App\Business\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ActiveScope implements Scope
{
    /**
     * @param Builder $builder
     * @param Model $model
     * @return $this
     */
    public function apply(Builder $builder, Model $model)
    {
        return $builder->where('active', '=', 1);
    }
}