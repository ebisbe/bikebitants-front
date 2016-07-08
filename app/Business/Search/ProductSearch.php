<?php

namespace App\Business\Search;

use App\Product;
use Illuminate\Http\Request;
use Jenssegers\Mongodb\Eloquent\Builder;
use StaticVars;

class ProductSearch
{

    /**
     * @param Request $filters
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function apply(Request $filters)
    {
        return static::applyDecoratorsFromRequest($filters, (new Product)->newQuery());
    }

    /**
     * Get default filtering values
     * @return array
     */
    private static function getDefaultFilters()
    {
        return [
            'min_price' => StaticVars::filterMinimumValue(),
            'max_price' => StaticVars::filterMaximumValue(),
            'sort' => StaticVars::filterSortingTypeSelected(),
            // Show must be alwasy the last item of the Collection
            'show' => StaticVars::filterShowSelected(),
        ];
    }

    /**
     * For each input received from the request apply it's own filter.
     * @param Request $filters
     * @param Builder $query
     * @return Builder
     */
    private static function applyDecoratorsFromRequest(Request $filters, Builder $query)
    {
        foreach (static::getFilters($filters) as $filterName => $value) {

            $decorator = static::createFilterDecorator($filterName);

            if (static::isValidDecorator($decorator)) {
                $query = $decorator::apply($query, $value);
            }

        }
        return $query;
    }

    /**
     * Return applied filters. Whether are the default or the requested.
     * @param Request $filters
     * @return array
     */
    public static function getFilters(Request $filters)
    {
        return array_merge(static::getDefaultFilters(), $filters->all());
    }

    /**
     * Given a filter name find it's own filter class
     * @param $name
     * @return string
     */
    private static function createFilterDecorator($name)
    {
        return __NAMESPACE__ . '\\Filters\\' . studly_case($name);
    }

    /**
     * Check if a filter exits
     * @param $decorator
     * @return bool
     */
    private static function isValidDecorator($decorator)
    {
        return class_exists($decorator);
    }
}