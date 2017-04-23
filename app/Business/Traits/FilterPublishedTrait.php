<?php

namespace App\Business\Traits;

use App\Business\Scopes\FilterPublishedScope;

trait FilterPublishedTrait
{

    public static function bootFilterPublishedTrait()
    {
        static::addGlobalScope(new FilterPublishedScope());
    }
}
