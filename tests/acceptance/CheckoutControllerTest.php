<?php

use App\Business\Traits\Tests\ProductTrait;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CheckoutControllerTest extends TestCase
{
    use ProductTrait;

    /** @test */
    public function add_product_and_see_checkout()
    {
        $this->addSimpleProduct();

        $this->visit('/checkout')
            ->seePageIs('/checkout');
    }
}
