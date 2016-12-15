<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SimpleProductTest extends TestCase
{
    /**
     * @test
     */
    public function find_simple_product_at_home()
    {
        $this->visit('/')
            ->see('Simple Product')
            ->click('Simple Product')
            ->see('Simple Product')
            ->see('Category 1')
            ->see('Subcategory 1')
            ->seePageIs($this->link('product/simple-product'))
            ->seeRouteIs('shop.product', ['slug' => 'simple-product']);
    }
}
