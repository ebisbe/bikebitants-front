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
            ->see('Total<span>12.10')

            ->type('DISCOUNT10', 'coupon')
            ->press('cart.apply_coupon')
            ->see('DISCOUNT10<span>-10%')
            ->see('Total<span>10.89')
            ;
    }
}