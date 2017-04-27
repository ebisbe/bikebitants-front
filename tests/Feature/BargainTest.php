<?php

namespace Tests\Feature;

use App\Product;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BargainTest extends TestCase
{
    public function tearDown()
    {
        Product::truncate();
    }

    /** @test */
    public function it_views_bargains_from_shop()
    {
        //arrange
        /** We are sending the array prices just because we need to filter through the prices and we need some.
         * Otherwise is generated correctly when you ad variations with prices */
        factory(Product::class)->states('bargain')->create(['name' => 'Variable Product 2', 'prices' => [1]]);
        factory(Product::class)->create(['name' => 'Simple Product']);

        //act
        $response = $this->get(route('shop.bargain'));

        //assert
        $response
            ->assertStatus(200)
            ->assertSee('Variable Product 2')
            ->assertSee('Oferta Bikebitants')
            ->assertSee('layout.shop')
            ->assertSee('bargain.title')
            ->assertSee('bargain.description')
            ->assertDontSee('Simple Product')
        ;
    }
}
