<?php

use App\Business\Repositories\ProductRepository;
use App\Business\Search\Filters\MaxPrice;
use App\Business\Search\Filters\MinPrice;
use App\Business\Search\Filters\Slug;
use App\Business\Search\Filters\Sort;
use App\Business\Search\Filters\SortFilterNotFound;
use App\Business\Search\Filters\SubSlug;
use App\Business\Search\ProductSearch;

class ProductSearchTest extends TestCase
{
    /** @var  ProductSearch */
    public $productSearch;

    public function setUp()
    {
        $this->productSearch = new ProductSearch(new ProductRepository());
    }

    /** @test */
    public function set_empty_request()
    {
        $this->productSearch->applyFilters([]);

        $this->assertEquals([
            'sort' => 'featured',
            'min_price' => 1,
            'max_price' => 500
        ], $this->productSearch->getFilters()->toArray());
    }

    /** @test */
    public function set_request_with_data()
    {
        $this->productSearch->applyFilters(['sort' => 'high_to_low', 'additional' => 'param']);

        $this->assertEquals([
            'sort' => 'high_to_low',
            'min_price' => 1,
            'max_price' => 500,
            'additional' => 'param'
        ], $this->productSearch->getFilters()->toArray());
    }

    /** @test */
    public function get_cache_tags_without_filters()
    {
        $this->assertEquals([ProductSearch::GLOBAL_CACHE_TAG], $this->productSearch->getCacheTags());
    }

    /** @test */
    public function get_cache_tags_with_slug_filter()
    {
        $this->productSearch->applyFilters(['slug' => 'val_slug']);

        $this->assertEquals(['val_slug'], $this->productSearch->getCacheTags());
    }

    /** @test */
    public function get_cache_tags_with_subslug_filter()
    {
        $this->productSearch->applyFilters(['slug' => 'val_slug', 'subslug' => 'val_subslug']);

        $this->assertEquals(['val_slug', 'val_subslug'], $this->productSearch->getCacheTags());
    }

    /** @test */
    public function test_filter_max_price()
    {
        $this->assertEquals([
            'prices' => ['$lte' => 25]
        ], MaxPrice::apply(25));

        $this->assertEquals([
            'prices' => ['$lte' => 25]
        ], MaxPrice::apply('25'));

        $this->assertEquals([
            'prices' => ['$lte' => 25]
        ], MaxPrice::apply('25e'));
    }

    /** @test */
    public function test_filter_min_price()
    {
        $this->assertEquals([
            'prices' => ['$gte' => 25]
        ], MinPrice::apply(25));

        $this->assertEquals([
            'prices' => ['$gte' => 25]
        ], MinPrice::apply('25'));

        $this->assertEquals([
            'prices' => ['$gte' => 25]
        ], MinPrice::apply('25e'));
    }

    /** @test */
    public function test_filter_slug_and_subslug()
    {
        $this->assertEquals([
            'categories' => ['$in' => [25]]
        ], Slug::apply(25));

        $this->assertEquals([
            'categories' => ['$in' => ['25e']]
        ], Slug::apply('25e'));

        $this->assertEquals([
            'categories' => ['$in' => [25]]
        ], SubSlug::apply(25));

        $this->assertEquals([
            'categories' => ['$in' => ['25e']]
        ], SubSlug::apply('25e'));
    }

    /** @test */
    public function test_filter_sort()
    {
        $this->assertEquals([
            'prices' => 1
        ], Sort::apply('low_to_high'));

        $this->assertEquals([
            'prices' => -1
        ], Sort::apply('high_to_low'));

        $this->assertEquals([
            'created_at' => -1, 'prices' => 1
        ], Sort::apply('newness'));

        $this->assertEquals([
            'is_featured' => -1, 'prices' => 1
        ], Sort::apply('featured'));

        $this->assertEquals([
            'is_discounted' => -1, 'prices' => 1
        ], Sort::apply('discounted'));

        try {
            Sort::apply('invented');
        } catch (SortFilterNotFound $e) {
            $this->assertEquals('No sorting option found for [invented]', $e->getMessage());
            return ;
        }

        $this->fail('Should receive SortFilterNotFound');
    }

    /** @test */
    public function apply_decorators_from_empty_request()
    {
        $query_params = $this->productSearch->applyDecoratorsFromRequest();

        $this->assertEquals([
            ['is_featured' => -1, 'prices' => 1],
            ['prices' => ['$gte' => 1]],
            ['prices' => ['$lte' => 500]],
            ['status' => 2],
            ['deleted_at' => null]
        ], $query_params->toArray());
    }

    /** @test */
    public function apply_decorators_from_full_request()
    {
        $this->productSearch->applyFilters([
            'sort' => 'newness',
            'slug' => 'category',
            'subslug' => 'subcategory'
        ]);
        $query_params = $this->productSearch->applyDecoratorsFromRequest();

        $this->assertEquals([
            ['created_at' => -1, 'prices' => 1],
            ['prices' => ['$gte' => 1]],
            ['prices' => ['$lte' => 500]],
            ['categories' => ['$in' => ['category']]],
            ['categories' => ['$in' => ['subcategory']]],
            ['status' => 2],
            ['deleted_at' => null]
        ], $query_params->toArray());
    }
}