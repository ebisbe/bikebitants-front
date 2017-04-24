<?php

namespace Tests\Acceptance;

use App\Business\Traits\Tests\ProductTrait;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CatalogueTest extends TestCase
{
    use ProductTrait;

    /** @test */
    public function it_sees_two_products_at_shop()
    {
        $this->createTax();
        $this->createSimpleProduct();
        $this->createProductWithThreeVariations();

        $response = $this->get(route('shop.catalogue'));

        $response
            ->assertStatus(200)
            ->assertSee('Simple Product')
            ->assertSee('Variation Product');
    }

    /** @test */
    public function it_sees_each_product_at_each_category()
    {
        $this->createTax();
        $this->createSimpleProduct();
        $this->createProductWithThreeVariations();

        $response = $this->get(route('shop.slug', ['slug' => 'category-1']));
        $response
            ->assertStatus(200)
            ->assertSee('Simple Product')
            ->assertDontSee('Variation Product');

        $response = $this->get(route('shop.slug', ['slug' => 'category-2']));
        $response
            ->assertStatus(200)
            ->assertSee('Variation Product')
            ->assertDontSee('Simple Product');
    }
}
