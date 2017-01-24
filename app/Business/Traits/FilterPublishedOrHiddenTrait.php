<?php

namespace App\Business\Traits;

use App\Business\Scopes\FilterPublishedOrHiddenScope;

trait FilterPublishedOrHiddenTrait
{

    public static function bootFilterPublishedOrHiddenTrait()
    {
        static::addGlobalScope(new FilterPublishedOrHiddenScope());
    }
}
