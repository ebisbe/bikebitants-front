<?php

namespace App\Business\Scopes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Scope;

class HasProductsScope implements Scope
{
    /**
     * @param Builder $builder
     * @param Model $model
     * @return mixed
     */
    public function apply(Builder $builder, Model $model)
    {
        return $builder->where('products_count', '>', 0);
    }
}
