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
                return ['is_featured' => 1];
                break;

            case 'discounted';
                return ['is_discounted' => -1];
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