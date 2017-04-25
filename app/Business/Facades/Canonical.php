<?php

namespace App\Business\Facades;

use Illuminate\Support\Facades\Facade;

class Canonical extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'canonical';
    }
}
