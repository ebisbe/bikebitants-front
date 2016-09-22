<?php

namespace App\Business\Search;

use App\Shop\PublishedProduct;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Jenssegers\Mongodb\Eloquent\Builder;
use StaticVars;
use Illuminate\Support\Collection;
/**
 * [
 * {$project: {name:1, prices:1, status:1, featured:1}},
 * {$unwind:'$prices'},
 * {$match:{"$and":[{"prices":{"$lte":100}},{"prices":{"$gte":90}},{"status":2},{"deleted_at":null}]}},
 * {$group: {_id:"$_id", name: {"$first": "$name"}, status:  {"$first": "$status"}, featured:  {"$first": "$featured"}}}
 * ]
 */
class ProductSearch
{

    /**
     * @param Request $filters
     * @param Route $route
     * @return Builder
     */
    public static function apply(Request $filters, Route $route)
    {
        $query = (new PublishedProduct())->newQuery()->with('brand');
        return static::applyDecoratorsFromRequest($filters, $query, $route);
    }

    /**
     * Get default filtering values
     * @return Collection
     */
    private static function getDefaultFilters()
    {
        return collect([
            // Show must be alwasy the first item of the Collection because the filter has a paginate().
            'show' => StaticVars::filterShowSelected(),
            'min_price' => StaticVars::filterMinimumValue(),
            'max_price' => StaticVars::filterMaximumValue(),
            'sort' => StaticVars::filterSortingTypeSelected(),
        ]);
    }

    /**
     * For each input received from the request apply it's own filter.
     * @param Request $filters
     * @param Builder $query
     * @param Route $route
     * @return Builder
     */
    private static function applyDecoratorsFromRequest(Request $filters, Builder $query, Route $route)
    {
        foreach (static::getFilters($filters, $route) as $filterName => $value) {

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
     * @param Route $route
     * @return static
     */
    public static function getFilters(Request $filters, Route $route)
    {
        return static::getDefaultFilters()
            ->merge($filters->all())
            ->merge($route->parameters())
            ->reverse();
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