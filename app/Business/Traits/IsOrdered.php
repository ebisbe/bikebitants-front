<?php

namespace App\Business\Traits;

use App\Business\Scopes\ByOrderAsc;

trait IsOrdered
{
    public static function bootIsOrdered()
    {
        static::addGlobalScope(new ByOrderAsc());
    }
}