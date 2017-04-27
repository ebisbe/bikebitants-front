<?php

namespace Tests\Feature;

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

    /** @test */
    public function it_doesnt_renders_canonical_on_category()
    {
        $this->createTax();
        $this->createSimpleProduct();
        $this->createProductWithThreeVariations();

        $response = $this->get(route('shop.slug', ['slug' => 'category-1']));
        $response
            ->assertDontSee('<link rel="canonical" href="http://bikebitants.dev/category-1">');
    }

    /** @test */
    public function it_renders_canonical_on_category()
    {
        $this->createTax();
        $this->createSimpleProduct();
        $this->createProductWithThreeVariations();

        $response = $this->get(route('shop.slug', ['slug' => 'category-1']) . '?home=home');
        $response
            ->assertSee('<link rel="canonical" href="http://bikebitants.dev/category-1">');
    }

    /** @test */
    public function it_doesnt_renders_canonical_on_subcategory()
    {
        $this->createTax();
        $this->createSimpleProduct();
        $this->createProductWithThreeVariations();

        $response = $this->get(route('shop.subslug', ['slug' => 'category-1', 'subslug' => 'sub-category-1']));
        $response
            ->assertDontSee('<link rel="canonical"');
    }

    /** @test */
    public function it_renders_canonical_on_subcategory()
    {
        $this->createTax();
        $this->createSimpleProduct();
        $this->createProductWithThreeVariations();

        $response = $this->get(
            route('shop.subslug', ['slug' => 'category-1', 'subslug' => 'sub-category-1']) . '?home=home'
        );
        $response
            ->assertSee('<link rel="canonical" href="http://bikebitants.dev/category-1/sub-category-1">');
    }
}
