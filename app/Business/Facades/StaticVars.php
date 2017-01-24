<?php

namespace App\Business\Facades;

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Collection;

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
 * @method static Collection productDetail()
 * @method static Collection productRelated()
 * @method static Collection homeLeft()
 * @method static Collection homeCategories()
 * @method static Collection brandMain()
 *
 * @method static Collection emptyCart()
 *
 * @method static integer filterMinimumValue()
 * @method static integer filterMaximumValue()
 * @method static Collection filterSortingType()
 * @method static string filterSortingTypeSelected()
 * @method static Collection filterShow()
 * @method static string filterShowSelected()
 *
 * @method static string imgWrapper()
 *
 * @method static string layoutHeader($layoutHeader)
 * @method static string layoutTopHeader($layoutTopHeader)
 *
 * @method static string emailValidation()
 *
 * @method static string wordpressDateTime()
 *
 * @method static string logo()
 *
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
