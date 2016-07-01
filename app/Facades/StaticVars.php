<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
/**
 * Class StaticVars
 * @package App\Business
 *
 * @method static string company()
 * @method static string email()
 * @method static string telephone()
 * @method static string slogan()
 * @method static string facebook()
 * @method static string twitter()
 * @method static string instagram()
 * @method static string linkedin()
 *
 * @method static \Illuminate\Support\Collection productDetail()
 * @method static \Illuminate\Support\Collection productRelated()
 * @method static \Illuminate\Support\Collection emptyCart()
 *
 */
class StaticVars extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'staticvars';
    }
}