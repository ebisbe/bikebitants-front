<?php

use App\Product;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BargainTest extends BrowserKitTest
{
    public function tearDown()
    {
        Product::truncate();
    }

    /** @test */
    public function view_bargains()
    {
        //arrange
        /** We are sending the array prices just because we need to filter through the prices and we need some.
         * Otherwise is generated correctly when you ad variations with prices */
        factory(Product::class)->states('bargain')->create(['name' => 'Variable Product 2', 'prices' => [1]]);
        factory(Product::class)->create(['name' => 'Simple Product']);

        //act
        $this->visit(route('shop.bargain'));

        //assert
        $this->see('Variable Product 2')
            ->see('Oferta Bikebitants')
            ->see('layout.shop')
            ->see('bargain.title')
            ->see('bargain.description')
            ->dontSee('Simple Product')
        ;
    }
}
