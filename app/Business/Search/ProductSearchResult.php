<?php

namespace App\Business\Search;

use Illuminate\Support\Collection;

class ProductSearchResult
{
    private $products;
    private $filters;
    private $min_price;
    private $max_price;
    private $sorting_types;

    /**
     * ProductSearchResult constructor.
     * @param $products
     * @param Collection $filters
     * @param int $min_price
     * @param int $max_price
     * @param Collection $sorting_types
     */
    public function __construct(
        $products,
        Collection $filters,
        int $min_price,
        int $max_price,
        Collection $sorting_types
    ) {
        $this->products = $products;
        $this->filters = $filters;
        $this->min_price = $min_price;
        $this->max_price = $max_price;
        $this->sorting_types = $sorting_types;
    }

    /**
     * @return mixed
     */
    public function products()
    {
        return $this->products;
    }


    /**
     * @param $filter_name
     * @return mixed
     * @throws ResultFilterNotFound
     */
    public function filters($filter_name)
    {
        if (!isset($this->filters[$filter_name])) {
            throw new ResultFilterNotFound("Filter [{$filter_name}] not found.");
        }

        return $this->filters[$filter_name];
    }

    /**
     * @return mixed
     */
    public function minPrice()
    {
        return $this->min_price;
    }

    /**
     * @return mixed
     */
    public function maxPrice()
    {
        return $this->max_price;
    }

    /**
     * @return Collection
     */
    public function sortingTypes()
    {
        return $this->sorting_types;
    }


}