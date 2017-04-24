<?php

namespace Tests\Acceptance;

use App\Business\Traits\Tests\ProductTrait;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class TagTest extends TestCase
{
    use ProductTrait;

    /** @test */
    public function it_sees_label_page()
    {
        $this->createSimpleProduct();
        $this->createTax();

        $response = $this->get(route('shop.tag', ['slug' => 'label1']));
        $response
            ->assertStatus(200)
            ->assertSee('Simple Product')
            ->assertDontSee('Variation product');
    }

    /** @test */
    public function it_redirects_from_label_name_to_label_slug()
    {
        $this->createSimpleProduct();
        $this->createTax();

        $response = $this->get(route('shop.tag', ['slug' => 'Label1']));
        $response
            ->assertStatus(301)
            ->assertRedirect(route('shop.tag', ['slug' => 'label1']));
    }

    /** @test */
    public function it_sees_404_on_label_page()
    {
        $response = $this->get(route('shop.tag', ['slug' => 'label1']));
        $response->assertStatus(404);
    }

    /** @test */
    public function it_sees_label_in_product_page()
    {
        $this->createTax();
        $this->createSimpleProduct();

        $response = $this->get('/simple-product');

        $response
            ->assertStatus(200)
            ->assertSee('Label1');
    }
}
