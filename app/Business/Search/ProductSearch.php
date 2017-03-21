<?php

namespace App\Business\Search;

use App\Business\Models\Shop\Product;
use App\Business\Search\Filters\Filter;
use App\Business\Search\Filters\MaxPrice;
use App\Business\Search\Filters\MinPrice;
use App\Business\Search\Filters\Slug;
use App\Business\Search\Filters\Sort;
use App\Business\Search\Filters\SubSlug;
use Jenssegers\Mongodb\Eloquent\Builder;
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
    protected $applied_filters = [];
    /** @var  Collection */
    protected $filters;
    const SLUG = 'slug';
    const SUBSLUG = 'subslug';


    /** Filters for product page */
    const MIN_PRICE = 1;
    const MAX_PRICE = 500;
    //protected $show = [8 => 8, 12 => 12, 18 => 18, 24 => 24, 'all' => 'all'];
    //protected $filterPage = 1;

    const FEATURED = 'featured';
    const NEWNESS = 'newness';
    const LOW_TO_HIGH = 'low_to_high';
    const HIGH_TO_LOW = 'high_to_low';
    const DISCOUNTED = 'discounted';

    const GLOBAL_CACHE_TAG = 'shop_search';

    /**
     * Check if query already saved to cache and if not generate a new one
     * @return ProductSearchResult
     */
    public function apply(): ProductSearchResult
    {
        $result =  Cache::tags($this->getCacheTags())
            ->rememberForever($this->getCacheKey(), function () {
                $query_params = $this->applyDecoratorsFromRequest();
                return $this->query($query_params);
            });

        return new ProductSearchResult(
            $result,
            $this->getFilters(),
            self::MIN_PRICE,
            self::MAX_PRICE,
            self::sortingTypes()
        );
    }

    /**
     * Base query
     *
     * TODO Divide filters.
     * Before unwind filter with $categories, $status and $deleted_at. After unwind use $prices
     *
     * @param $filters
     * @return mixed
     */
    private function query(Collection $filters)
    {
        return (new Product())->newQuery()
            ->raw(function ($collection) use ($filters) {
                $sort = $filters->shift();
                return $collection
                    ->aggregate([
                        //['$project' => ['name' => 1, 'prices' => 1, 'status' => 1, 'is_featured' => 1]],
                        ['$unwind' => '$prices'],
                        [
                            '$match' =>
                                ['$and' => $filters->toArray()]
                        ],
                        [
                            '$group' => [
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
                            ]
                        ],
                        ['$sort' => $sort]
                    ]);
            });
    }

    /**
     * For each input received from the request apply it's own filter.
     * @return Collection
     */
    public function applyDecoratorsFromRequest(): Collection
    {
        $query = collect([]);

        foreach ($this->getFilters() as $filterName => $value) {
            /** @var Filter|MaxPrice|MinPrice|Slug|Sort|SubSlug $decorator */
            $decorator = $this->createFilterDecorator($filterName);

            if ($this->isValidDecorator($decorator)) {
                $query->push($decorator::apply($value));
            }
        }

        $query->push(['status' => 2]);
        $query->push(['deleted_at' => null]);

        return $query;
    }

    /**
     * @param array $filters
     */
    public function applyFilters(array $filters)
    {
        $this->filters = null;
        $this->applied_filters = $filters;
    }

    /**
     * Get default filtering values
     * @return Collection
     */
    public function getDefaultFilters(): Collection
    {
        return collect([
            'sort' => self::FEATURED,
            'min_price' => self::MIN_PRICE,
            'max_price' => self::MAX_PRICE,
            self::SLUG => '',
            self::SUBSLUG => ''
        ]);
    }


    /**
     * Return applied filters. Whether are the default or the requested.
     * @return Collection
     */
    public function getFilters(): Collection
    {
        if (!is_null($this->filters)) {
            return $this->filters;
        }

        $this->filters = $this->getDefaultFilters()
            ->merge($this->applied_filters)
            ->filter();

        return $this->filters;
    }

    /**
     * @return Collection
     */
    public function getCacheTags(): Collection
    {
        $tags = $this->getFilters()
            ->filter(function ($params, $key) {
                return in_array($key, [self::SLUG, self::SUBSLUG]);
            });

        if ($tags->isEmpty()) {
            return collect([self::GLOBAL_CACHE_TAG]);
        }

        return $tags->values();
    }

    /**
     * Generate Cache Key
     * @return string
     */
    private function getCacheKey(): string
    {
        return md5($this->getFilters()->toJson());
    }

    /**
     * Given a filter name find it's own filter class
     * @param $name
     * @return string
     */
    private function createFilterDecorator($name): string
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

    public static function sortingTypes()
    {
        return collect([
            self::NEWNESS,
            self::LOW_TO_HIGH,
            self::HIGH_TO_LOW,
            'selected' => self::FEATURED,
            self::DISCOUNTED
        ]);
    }
}
