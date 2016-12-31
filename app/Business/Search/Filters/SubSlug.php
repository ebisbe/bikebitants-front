<?php
namespace App\Business\Search\Filters;

use Jenssegers\Mongodb\Eloquent\Builder;

class SubSlug implements Filter {

    /**
     * @param mixed $value
     * @return Builder
     */
    public static function apply($value)
    {
        return ['categories' => ['$in' => [$value]]];
    }
}