<?php

namespace App\Business\Scopes;

use App\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Scope;

class FilterPublishedScope implements Scope
{
    /**
     * @param Builder $builder
     * @param Model $model
     * @return mixed
     */
    public function apply(Builder $builder, Model $model)
    {
        return $builder->whereIn('status', [Product::PUBLISHED, Product::HIDDEN]);
    }
}
