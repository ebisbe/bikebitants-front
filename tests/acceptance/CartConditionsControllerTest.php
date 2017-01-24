<?php

use App\Business\Traits\Tests\ProductTrait;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CartConditionsControllerTest extends TestCase
{
    use ProductTrait, DatabaseMigrations;

    /** @test */
    public function add_new_shipping_to_cart_without_state_expecting_error()
    {
        $this->postJson('/api/cart-conditions')
            ->seeJson([
                'state' => ['validation.required'],
            ])
            ->seeStatusCode(422);
    }

    /** @test */
    public function add_new_shipping_to_cart()
    {
        $this->createTax();
        $this->postJson(
            '/api/cart-conditions',
            [
                'country' => 'ES',
                'state' => 'B'
            ]
        )
            ->seeJson([
                'name' => 'checkout.total',
                'value' => '3.31 &euro;'
            ])
            ->seeStatusCode(200);
    }
}
