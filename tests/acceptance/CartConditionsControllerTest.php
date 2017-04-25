<?php

namespace Tests\Acceptance;

use App\Business\Traits\Tests\ProductTrait;
use Tests\TestCase;

class CartConditionsControllerTest extends TestCase
{
    use ProductTrait;

    /** @test */
    public function it_adds_new_shipping_to_cart_without_state_expecting_error()
    {
        $response = $this->postJson('/api/cart-conditions');
        $response
            ->assertJson([
                'state' => ['validation.required'],
            ])
            ->assertStatus(422);
    }

    /** @test */
    public function it_adds_new_shipping_to_cart()
    {
        $this->createTax();
        $this->createZone();
        $this->createCountry();

        $response = $this->postJson(
            '/api/cart-conditions',
            [
                'country' => 'ES',
                'state' => 'B'
            ]
        );
        $response
            ->assertJsonFragment([[
                'name' => 'checkout.total',
                'value' => '5.00 &euro;'
            ]])
            ->assertStatus(200);
    }
}
