<?php

namespace App\Business\Search;

use App\Business\Models\Shop\Product;
use App\Business\Repositories\ProductRepository;
use App\Business\Search\Filters\Filter;
use App\Business\Search\Filters\MaxPrice;
use App\Business\Search\Filters\MinPrice;
use App\Business\Search\Filters\Slug;
use App\Business\Search\Filters\Sort;
use App\Business\Search\Filters\SubSlug;
use Illuminate\Support\Collection;

class ProductSearch
{
    protected $applied_filters = [];
    /** @var  Collection */
    protected $filters;
    const SLUG = 'slug';
    const SUBSLUG = 'subslug';


    /** Filters for product page */
    const MIN_PRICE = 1;
    const MAX_PRICE = 1000;
    //protected $show = [8 => 8, 12 => 12, 18 => 18, 24 => 24, 'all' => 'all'];
    //protected $filterPage = 1;

    const FEATURED = 'featured';
    const NEWNESS = 'newness';
    const LOW_TO_HIGH = 'low_to_high';
    const HIGH_TO_LOW = 'high_to_low';
    const DISCOUNTED = 'discounted';

    /**
     * Check if query already saved to cache and if not generate a new one
     * @return ProductSearchResult
     */
    public function apply()
    {
        $limit = $this->getLimit();
        $page = $this->getPage();

        $result =  $this
            ->applyDecoratorsFromRequest((new ProductRepository()))
            ->with(['brand', 'category'])
            ->paginate($limit, ['*'], 'page', $page);

        return new ProductSearchResult(
            $result,
            $this->getFilters(),
            self::MIN_PRICE,
            self::MAX_PRICE,
            self::sortingTypes()
        );
    }

    /**
     * For each input received from the request apply it's own filter.
     * @param ProductRepository $query
     * @return ProductRepository|Collection
     */
    public function applyDecoratorsFromRequest(ProductRepository $query): ProductRepository
    {
        foreach ($this->getFilters() as $filterName => $value) {
            /** @var Filter|MaxPrice|MinPrice|Slug|Sort|SubSlug $decorator */
            $decorator = $this->createFilterDecorator($filterName);

            if ($this->isValidDecorator($decorator)) {
                $decorator::apply($query, $value);
            }
        }

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
            'sort' => self::DISCOUNTED,
            'min_price' => self::MIN_PRICE,
            'max_price' => self::MAX_PRICE,
            'page' => 1,
            'per_page' => 160,
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
            self::FEATURED,
            'selected' => self::DISCOUNTED
        ]);
    }

    private function getPage(): int
    {
        return $this->getFilters()['page'];
    }

    private function getLimit(): int
    {
        return $this->getFilters()['per_page'];
    }
}
