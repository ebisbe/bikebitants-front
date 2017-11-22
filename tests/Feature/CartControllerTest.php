<?php

namespace Tests\Feature;

use App\Business\Traits\Tests\ProductTrait;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use ProductTrait;

    /** @test */
    public function it_sees_empty_cart()
    {
        $this->createTax();
        $response = $this->get(route('cart.index'));

        $response
            ->assertStatus(200)
            ->assertSee('cart.empty_cart_h1')
            ->assertSee('cart.empty_cart_message');
    }

    /** @test */
    public function it_adds_a_product_and_goes_to_cart()
    {
        $this->createTax(21);
        $this->createSimpleProduct();
        $this->createDiscounts();

        $this->addSimpleProduct();
        $response = $this
            ->get(route('cart.index'));

        $response
            ->assertStatus(200)
            ->assertSee('Simple Product')
            ->assertSee('12.10')
            ->assertSee('Total<span>12.10');

        // TODO this should be done via api
        $this->postJson(route('coupon.store', ['coupon' => 'DISCOUNT20']));
        $response = $this->postJson(route('coupon.store', ['coupon' => 'DISCOUNT10']));
        $response->assertStatus(302);

        $response = $this
            ->get(route('cart.index'));

        $response
            ->assertStatus(200)
            ->assertSee('discount10<span>-10%')
            ->assertDontSee('discount20<span>-20%')
            ->assertSee('Total<span>10.89');
    }
}
