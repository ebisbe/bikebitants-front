<?php

namespace Tests\Acceptance;

use App\Business\Traits\Tests\ProductTrait;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\BrowserKitTesting\HttpException;
use Tests\TestCase;

class BrandTest extends TestCase
{
    use ProductTrait;

    /** @test */
    public function it_finds_brand_and_see_simple_product()
    {
        $this->createTax();
        $this->createSimpleProduct();

        $response = $this->get($this->link('tienda/simple-brand'));

        $response
            ->assertStatus(200)
            ->assertSee('Simple Brand')
            ->assertSee('Simple Product');
    }

    /** @test */
    public function it_gets_404_from_unknown_brand()
    {
        $response = $this->get($this->link('tienda/luces-bicicleta'));
        $response->assertStatus(404);
    }

    /** @test */
    public function it_gets_all_brands_listed()
    {
        $this->createTax();
        $this->createSimpleProduct();

        $response = $this->get($this->link('/tienda/marcas'));

        $response
            ->assertStatus(200)
            ->assertSee('Simple Brand');
    }
}
