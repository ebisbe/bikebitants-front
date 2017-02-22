<?php

use App\Business\Traits\Tests\ProductTrait;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BrandTest extends BrowserKitTest
{
    use ProductTrait;

    /** @test */
    public function find_brand_and_see_simple_product()
    {
        $this->createTax();
        $this->createSimpleProduct();

        $this->visit($this->link('brand/simple-brand'))
            ->see('Simple Brand')
            ->see('Simple Product')
            ->seePageIs($this->link('brand/simple-brand'))
            ->seeRouteIs('shop.brand', ['slug' => 'simple-brand']);
    }
}
