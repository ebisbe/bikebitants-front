<?php

namespace App\Business\Search;

use App\Business\Models\Shop\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Jenssegers\Mongodb\Eloquent\Builder;
use StaticVars;
use Illuminate\Support\Collection;

/**
 * [
 * {$project: {name:1, prices:1, status:1, is_featured:1}},
 * {$unwind:'$prices'},
 * {$match:{"$and":[{"prices":{"$lte":100}},{"prices":{"$gte":90}},{"status":2},{"deleted_at":null}]}},
 * {$sort:{age: -1,posts:1}},
 * {$group: {_id:"$_id", name: {"$first": "$name"}, status:  {"$first": "$status"}, is_featured:  {"$first": "$is_featured"}}}
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
        list($filters, $sort) = static::applyDecoratorsFromRequest($filters, [], $route);

        $query = (new Product())->newQuery()
            ->with('brand')
            ->raw(function ($collection) use ($filters, $sort) {
                return $collection->aggregate([
                    //['$project' => ['name' => 1, 'prices' => 1, 'status' => 1, 'is_featured' => 1]],
                    ['$unwind' => '$prices'],
                    ['$match' =>
                        ['$and' => $filters]
                    ],
                    ['$sort' => $sort],
                    ['$group' => [
                        '_id' => '$_id',
                        'name' => ['$first' => '$name'],
                        'status' => ['$first' => '$status'],
                        'is_featured' => ['$first' => '$is_featured'],
                        'images' => ['$first' => '$images'],
                        'labels' => ['$first' => '$labels'],
                        'is_discounted' => ['$first' => 'is_discounted'],
                        'description' => ['$first' => '$description'],
                        'slug' => ['$first' => '$slug'],
                        'variations' => ['$first' => '$variations']
                    ]]
                ]);
            });

        return $query;
    }

    /**
     * Get default filtering values
     * @return Collection
     */
    private static function getDefaultFilters()
    {
        return collect([
            'sort' => StaticVars::filterSortingTypeSelected(),
            'min_price' => StaticVars::filterMinimumValue(),
            'max_price' => StaticVars::filterMaximumValue(),
        ]);
    }

    /**
     * For each input received from the request apply it's own filter.
     * @param Request $filters
     * @param $query
     * @param Route $route
     * @return Builder
     */
    private static function applyDecoratorsFromRequest(Request $filters, $query, Route $route)
    {
        foreach (static::getFilters($filters, $route) as $filterName => $value) {

            $decorator = static::createFilterDecorator($filterName);

            if (static::isValidDecorator($decorator)) {
                array_push($query, $decorator::apply($value));
            }

        }
        $filters = array_merge($query, [
            ['status' => 2],
            ['deleted_at' => null]
        ]);
        $sort = array_shift($filters);

        return [$filters, $sort];
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
            ->merge($route->parameters());
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