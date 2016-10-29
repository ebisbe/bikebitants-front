<?php

namespace App\Business\Traits;

use App\Business\Scopes\ShopProductScope;

trait ProductsTrait
{

    public static function bootProductsTrait()
    {
        static::addGlobalScope(new ShopProductScope());
    }
}