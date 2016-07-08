<?php
namespace App\Business\Search\Filters;

use Jenssegers\Mongodb\Eloquent\Builder;

class Show implements Filter {

    /**
     * @param Builder $builder
     * @param mixed $value
     * @return mixed
     */
    public static function apply(Builder $builder, $value)
    {
        if($value == 'all') {
            return $builder->get();
        }
        return $builder->paginate((int)$value);
    }
}