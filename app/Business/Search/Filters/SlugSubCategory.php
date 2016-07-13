<?php
namespace App\Business\Search\Filters;

use Jenssegers\Mongodb\Eloquent\Builder;

class SlugSubCategory implements Filter {

    /**
     * @param Builder $builder
     * @param mixed $value
     * @return Builder
     */
    public static function apply(Builder $builder, $value)
    {
        return $builder->whereIn('categories', [$value]);
    }
}