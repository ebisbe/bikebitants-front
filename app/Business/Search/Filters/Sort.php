<?php
namespace App\Business\Search\Filters;

class Sort implements Filter
{

    /**
     * @param mixed $value
     * @return array
     */
    public static function apply($value)
    {
        switch ($value) {
            case 'low_to_high';
                return ['prices' => 1];
                break;

            case 'high_to_low';
                return ['prices' => -1];
                break;

            case 'newness';
                return ['created_at' => -1];
                break;

            case 'featured';
                return ['featured' => 1];
                break;

            case 'discounted';
                return ['discounted' => -1];
                break;

//            case 'popularity';
//                return $builder->orderBy('created_at', 'desc');
//                break;
//
//            case 'average_rating';
//                return $builder->orderBy('created_at', 'desc');
//                break;

            default:
                return [];
        }

    }
}