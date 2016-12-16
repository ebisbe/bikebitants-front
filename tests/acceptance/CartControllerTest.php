<?php

use App\Business\Traits\Tests\ProductTrait;

class CartControllerTest extends TestCase {

    use ProductTrait;

    /**
     * @test
     */
    public function see_empty_cart()
    {
        $this->visit('/cart')
            ->see('cart.empty_cart_h1')
            ->see('cart.empty_cart_message');
    }

    /**
     * @test
     */
    public function add_product_and_go_to_cart()
    {
        $this
            ->addSimpleProduct()
            ->visit('/cart')
            ->see('Simple Product')
            ->see('12.10')
            ;
    }
}