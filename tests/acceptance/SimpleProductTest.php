<?php

namespace Tests\Acceptance;

use App\Business\Traits\Tests\ProductTrait;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\BrowserKitTesting\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class SimpleProductTest extends TestCase
{
    use ProductTrait;

    /** @test */
    public function it_finds_simple_product_at_home()
    {
        $this->createTax();
        $this->createSimpleProduct();

        $response = $this->get('/');

        $response
            ->assertStatus(200)
            ->assertSee('Simple Product');
    }

    /** @test */
    public function it_finds_simple_product_on_product_page()
    {
        $this->createTax();
        $this->createSimpleProduct();

        $response = $this->get(route('shop.slug', ['slug' => 'simple-product']));

        $response
            ->assertStatus(200)
            // TODO should reveiw all attributes
            ->assertSee('Simple Product');
    }

    /** @test */
    public function get_404_from_unknown_product()
    {
        $response = $this->get('/wp-content');

        $response->assertStatus(404);
    }

    /** @test */
    public function get_404_from_unknown_subcategory()
    {
        $response = $this->get('/wp-content/common.php.suspected');
        $response->assertStatus(404);
    }

    /** @test */
    public function find_subcategory()
    {
        $this->createTax();
        $this->createSimpleProduct();

        $response = $this->get(route('shop.subslug', ['slug' => 'category-1', 'subslug' => 'sub-category-1']));
        $response
            ->assertStatus(200)
            ->assertSee('Simple Product');
    }
}
