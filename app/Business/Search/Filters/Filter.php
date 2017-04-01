<?php
namespace App\Business\Search\Filters;

use App\Business\Repositories\ProductRepository;

interface Filter
{
    /**
     * Apply a given search value to the builder instance.
     *
     * @param ProductRepository $query
     * @param mixed $value
     * @return ProductRepository
     */
    public static function apply(ProductRepository $query, $value);
}
