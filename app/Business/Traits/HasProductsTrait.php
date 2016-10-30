<?php

namespace App\Business\Traits;

use App\Business\Scopes\HasProductsScope;

trait HasProductsTrait
{

    public static function bootHasProductsTrait()
    {
        static::addGlobalScope(new HasProductsScope());
    }
}