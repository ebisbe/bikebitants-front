<?php
namespace App\Business\Search\Filters;

use Jenssegers\Mongodb\Eloquent\Builder;

class Sort implements Filter {

    /**
     * @param Builder $builder
     * @param mixed $value
     * @return Builder
     */
    public static function apply(Builder $builder, $value)
    {
        switch($value) {
            case 'low_to_high';
                return $builder->orderBy('price', 'asc');
            break;

            case 'high_to_low';
                return $builder->orderBy('price', 'desc');
                break;

            case 'newness';
                return $builder->orderBy('created_at', 'desc');
                break;

            case 'featured';
                return $builder->orderBy('featured', 'desc');
                break;

            case 'discounted';
                return $builder->orderBy('discounted', 'desc');
                break;

//            case 'popularity';
//                return $builder->orderBy('created_at', 'desc');
//                break;
//
//            case 'average_rating';
//                return $builder->orderBy('created_at', 'desc');
//                break;

            default:
                return $builder;
        }

    }
}