<?php

namespace App\Business\Models\Shop;

use App\Business\Traits\HasProducts;
use App\Business\Traits\IsOrdered;
use App\Business\Traits\Presenters\CategoryPresenter;

/**
 * Class Category
 * @package App\Shop
 *
 */
class Category extends \App\Category
{
    use HasProducts, IsOrdered, CategoryPresenter;

    protected $with = ['children'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('father', function ($builder) {
            $builder->where('father_id', null);
        });
    }
}
