<?php

use App\Business\Traits\Tests\ProductTrait;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SimpleProductTest extends TestCase
{
    use ProductTrait, DatabaseMigrations;
    /** @test */
    public function find_simple_product_at_home()
    {

        $this->createTax();
        $this->createSimpleProduct();

        $this->visit('/')
            ->see('Simple Product')
            ->click('Simple Product')
            ->see('Simple Product')
            ->seePageIs($this->link('product/simple-product'))
            ->seeRouteIs('shop.product', ['slug' => 'simple-product']);
    }
}
