<?php

namespace Tests\Unit\ProductSearch;

use App\Business\Repositories\ProductRepository;
use App\Business\Search\Filters\MaxPrice;
use App\Business\Search\Filters\MinPrice;
use App\Business\Search\Filters\Slug;
use App\Business\Search\Filters\Sort;
use App\Business\Search\Filters\SortFilterNotFound;
use App\Business\Search\Filters\SubSlug;
use App\Business\Search\ProductSearch;
use Tests\TestCase;

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
            'max_price' => 1000,
            'page' => 1,
            'per_page' => 160
        ], $this->productSearch->getFilters()->toArray());
    }

    /** @test */
    public function set_request_with_data()
    {
        $this->productSearch->applyFilters(['sort' => 'high_to_low', 'additional' => 'param']);

        $this->assertEquals([
            'sort' => 'high_to_low',
            'min_price' => 1,
            'max_price' => 1000,
            'page' => 1,
            'per_page' => 160,
            'additional' => 'param'
        ], $this->productSearch->getFilters()->toArray());
    }

    /** @test */
    public function test_filter_sort()
    {
        try {
            Sort::apply((new ProductRepository()), 'invented');
        } catch (SortFilterNotFound $e) {
            $this->assertEquals('No sorting option found for [invented]', $e->getMessage());
            return;
        }

        $this->fail('Should receive SortFilterNotFound');
    }
}