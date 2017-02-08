<?php

use App\Product;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BargainTest extends BrowserKitTest
{
    use DatabaseMigrations;

    /** @test */
    public function view_bargains()
    {
        //arrange
        factory(Product::class)->states('bargain')->create(['name' => 'Variable Product 2']);
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
