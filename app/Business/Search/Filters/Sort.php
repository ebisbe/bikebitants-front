<?php
namespace App\Business\Search\Filters;

use App\Business\Repositories\ProductRepository;
use App\Business\Search\ProductSearch;

class Sort implements Filter
{

    /**
     * @param ProductRepository $query
     * @param mixed $value
     * @return ProductRepository
     * @throws SortFilterNotFound
     */
    public static function apply(ProductRepository $query, $value)
    {
        switch ($value) {
            case ProductSearch::LOW_TO_HIGH:
                $sort = $query->orderBy('prices', 'asc');
                break;

            case ProductSearch::HIGH_TO_LOW:
                $sort = $query->orderBy('prices', 'desc');
                break;

            case ProductSearch::NEWNESS:
                $sort = $query->orderBy('created_at', 'desc')->orderBy('prices', 'asc');
                break;

            case ProductSearch::FEATURED:
                $sort = $query->orderBy('is_featured', 'desc')->orderBy('prices', 'asc');
                break;

            case ProductSearch::DISCOUNTED:
                $sort = $query->orderBy('is_discounted', 'desc')->orderBy('prices', 'asc');
                break;

            default:
                throw new SortFilterNotFound('No sorting option found for [' . $value . ']');
        }
        return $sort;
    }
}
