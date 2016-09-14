<?php

namespace App\Business\Traits;

use App\Business\Scopes\PublishedProductScope;

trait PublishedProductsTrait
{

    public static function bootPublishedProductsTrait()
    {
        static::addGlobalScope(new PublishedProductScope());
    }
}