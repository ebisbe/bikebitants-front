<?php

namespace App\Business\Search;

use App\Business\Models\Shop\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Jenssegers\Mongodb\Eloquent\Builder;
use StaticVars;
use Illuminate\Support\Collection;
use Cache;

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
    /** @var  Request $filters */
    protected $filters;

    /** @var  Route $route */
    protected $route;

    public function __construct(Request $filters, Route $route)
    {
        $this->filters = $filters;
        $this->route = $route;
    }

    /**
     * Check if query already saved to cache and if not generate a new one
     * @return Builder
     */
    public function apply()
    {
        return Cache::tags($this->getCacheTags())
            ->rememberForever($this->getCacheKey(), function () {
                list($filters, $sort) = $this->applyDecoratorsFromRequest([]);
                return $this->query($filters, $sort);
            });
    }

    /**
     * Base query
     *
     * TODO Divide filters.
     * Before unwind filter with $categories, $status and $deleted_at. After unwind use $prices
     *
     * @param $filters
     * @param $sort
     * @return mixed
     */
    private function query($filters, $sort)
    {
        return (new Product())->newQuery()
            ->with('brand')
            ->raw(function ($collection) use ($filters, $sort) {
                return $collection->aggregate([
                    //['$project' => ['name' => 1, 'prices' => 1, 'status' => 1, 'is_featured' => 1]],
                    ['$unwind' => '$prices'],
                    ['$match' =>
                        ['$and' => $filters]
                    ],
                    ['$group' => [
                        '_id' => '$_id',
                        'prices' => ['$first' => '$prices'],
                        'name' => ['$first' => '$name'],
                        'status' => ['$first' => '$status'],
                        'is_featured' => ['$first' => '$is_featured'],
                        'images' => ['$first' => '$images'],
                        'labels' => ['$first' => '$labels'],
                        'is_discounted' => ['$first' => '$is_discounted'],
                        'stock' => ['$first' => '$stock'],
                        'description' => ['$first' => '$description'],
                        'slug' => ['$first' => '$slug'],
                        'variations' => ['$first' => '$variations'],
                        'introduction' => ['$first' => '$introduction'],
                        'rating' => ['$first' => '$rating'],
                    ]],
                    ['$sort' => $sort]
                ]);
            });
    }

    /**
     * @return array
     */
    private function getCacheTags()
    {
        return array_values($this->route->parameters());
    }

    /**
     * Generate Cache Key
     * @return string
     */
    private function getCacheKey()
    {
        return md5(json_encode($this->filters->all() + $this->route->parameters()));
    }

    /**
     * Get default filtering values
     * @return Collection
     */
    private function getDefaultFilters()
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
    private function applyDecoratorsFromRequest($query)
    {
        foreach ($this->getFilters() as $filterName => $value) {
            $decorator = $this->createFilterDecorator($filterName);

            if ($this->isValidDecorator($decorator)) {
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
     * @return static
     */
    public function getFilters()
    {
        return $this->getDefaultFilters()
            ->merge($this->filters->all())
            ->merge($this->route->parameters());
    }

    /**
     * Given a filter name find it's own filter class
     * @param $name
     * @return string
     */
    private function createFilterDecorator($name)
    {
        return __NAMESPACE__ . '\\Filters\\' . studly_case($name);
    }

    /**
     * Check if a filter exits
     * @param $decorator
     * @return bool
     */
    private function isValidDecorator($decorator)
    {
        return class_exists($decorator);
    }
}
