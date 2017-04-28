<?php

namespace App\Business\Traits;

use App\Business\Scopes\ProductsCountGreaterThanZero;

trait HasProducts
{

    public static function bootHasProducts()
    {
        static::addGlobalScope(new ProductsCountGreaterThanZero());
    }
}
