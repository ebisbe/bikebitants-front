<?php

use App\Business\Traits\Tests\ProductTrait;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\BrowserKitTesting\HttpException;

class BrandTest extends BrowserKitTest
{
    use ProductTrait;

    /** @test */
    public function find_brand_and_see_simple_product()
    {
        $this->createTax();
        $this->createSimpleProduct();

        $this->visit($this->link('tienda/simple-brand'))
            ->see('Simple Brand')
            ->see('Simple Product')
            ->seePageIs($this->link('tienda/simple-brand'))
            ->seeRouteIs('shop.brand', ['slug' => 'simple-brand']);
    }

    /** @test */
    public function get_404_from_unknown_brand()
    {
        try {
            $this->visit($this->link('tienda/luces-bicicleta'));
        } catch (HttpException $e) {
            $this->assertEquals($e->getPrevious()->getMessage(), 'exceptions.page_not_found');
            return;
        }

        $this->fail('Should receive exception.');
    }
}
