<?php

namespace App\Business\Traits;

use App\Business\Scopes\PublishedProductScope;

trait PublishedProducts
{

    public static function bootPublishedProducts()
    {
        static::addGlobalScope(new PublishedProductScope());
    }
}