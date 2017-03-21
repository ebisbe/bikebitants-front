<?php

use App\Business\Search\ProductSearchResult;
use App\Business\Search\ResultFilterNotFound;
use Illuminate\Support\Collection;

class ProductSearchResultTest extends TestCase
{
    /** @test */
    public function test_product_search_result()
    {
        $result = new ProductSearchResult(
            collect(),
            collect(['min_price' => 45]),
            3,
            450,
            collect(['selected' => 'unkown', 'newer'])
        );

        $this->assertInstanceOf(Collection::class, $result->products());
        $this->assertEquals(45, $result->filters('min_price'));
        $this->assertEquals(3, $result->minPrice());
        $this->assertEquals(450, $result->maxPrice());
        $this->assertEquals(['selected' => 'unkown', 'newer'], $result->sortingTypes()->toArray());

        try {
            $this->assertEquals(45, $result->filters('price'));
        } catch (ResultFilterNotFound $e) {
            $this->assertEquals('Filter [price] not found.', $e->getMessage());
            return;
        }

        $this->fail('Should receive ResultFilterNotFound.');
    }

}