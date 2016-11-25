<?php

namespace App\Business\Traits;

use App\Business\Scopes\LastCouponScope;

trait LastCouponTrait
{

    public static function bootProductsTrait()
    {
        static::addGlobalScope(new LastCouponScope());
    }
}