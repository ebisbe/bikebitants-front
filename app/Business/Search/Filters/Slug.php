<?php
namespace App\Business\Search\Filters;

use App\Business\Repositories\ProductRepository;

class Slug implements Filter
{

    /**
     * @param ProductRepository $query
     * @param mixed $value
     * @return ProductRepository
     */
    public static function apply(ProductRepository $query, $value)
    {
        return $query->whereIn('categories', [$value]);
    }
}
