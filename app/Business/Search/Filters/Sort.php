<?php
namespace App\Business\Search\Filters;

use App\Business\Search\ProductSearch;

class Sort implements Filter
{

    /**
     * @param mixed $value
     * @return array
     * @throws SortFilterNotFound
     */
    public static function apply($value): array
    {
        switch ($value) {
            case ProductSearch::LOW_TO_HIGH:
                $sort = ['prices' => 1];
                break;

            case ProductSearch::HIGH_TO_LOW:
                $sort = ['prices' => -1];
                break;

            case ProductSearch::NEWNESS:
                $sort = ['created_at' => -1, 'prices' => 1];
                break;

            case ProductSearch::FEATURED:
                $sort = ['is_featured' => -1, 'prices' => 1];
                break;

            case ProductSearch::DISCOUNTED:
                $sort = ['is_discounted' => -1, 'prices' => 1];
                break;

            default:
                throw new SortFilterNotFound('No sorting option found for [' . $value . ']');
        }
        return $sort;
    }
}
