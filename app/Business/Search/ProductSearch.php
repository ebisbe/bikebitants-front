<?php

namespace App\Business\Search;

use App\Category;
use App\Product;
use Illuminate\Http\Request;
use Jenssegers\Mongodb\Eloquent\Builder;
use MongoDB\BSON\ObjectID;
use StaticVars;
use Illuminate\Support\Collection;

class ProductSearch
{

    /**
     * @param Request $filters
     * @param $slugCategory
     * @param $slugSubCategory
     * @return Builder
     */
    public static function apply(Request $filters, $category, $slugSubCategory)
    {
        $query = (new Product)->newQuery()->with('brand');
        $categories = static::filterCategories($category, $slugSubCategory);
        return static::applyDecoratorsFromRequest($filters, $query, $categories);
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
     * @param Collection $categories
     * @return Builder
     */
    private static function applyDecoratorsFromRequest(Request $filters, Builder $query, Collection $categories)
    {
        foreach (static::getFilters($filters, $categories) as $filterName => $value) {

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
     * @param Collection $categories
     * @return static
     */
    public static function getFilters(Request $filters, Collection $categories = null)
    {
        return static::getDefaultFilters()
            ->merge(collect($filters->all()))
            ->merge($categories)
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

    /**
     * @param Category $slugCategory
     * @param string $slugSubCategory
     * @return Collection
     */
    private static function filterCategories(Category $cat, $slugSubCategory)
    {
        $categories = $cat->whereSlugSubCategory($slugSubCategory)
            ->map(function ($item, $key) {
                return $item->_id;
            });
        return collect(['category' => $categories]);
    }
}