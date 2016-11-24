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
                $sort = ['prices' => 1];
                break;

            case 'high_to_low';
                $sort = ['prices' => -1];
                break;

            case 'newness';
                $sort = ['created_at' => -1];
                break;

            case 'featured';
                $sort = ['is_featured' => 1];
                break;

            case 'discounted';
                $sort = ['is_discounted' => -1];
                break;

//            case 'popularity';
//                return $builder->orderBy('created_at', 'desc');
//                break;
//
//            case 'average_rating';
//                return $builder->orderBy('created_at', 'desc');
//                break;

            default:
                throw new \Exception('No sorting option found for ['.$value.']');
        }
        return $sort;
    }
}