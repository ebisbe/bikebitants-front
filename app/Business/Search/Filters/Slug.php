<?php
namespace App\Business\Search\Filters;

use Jenssegers\Mongodb\Eloquent\Builder;

class Slug implements Filter {

    /**
     * @param mixed $value
     * @return Builder
     */
    public static function apply($value)
    {
        return ['categories' => ['$in' => [$value]]];
    }
}