<?php

namespace App\Business\Traits;

use App\Business\Scopes\GeoIpTaxScope;

trait GeoIpTrait
{

    public static function bootGeoIpTrait()
    {
        static::addGlobalScope(new GeoIpTaxScope());
    }
}
