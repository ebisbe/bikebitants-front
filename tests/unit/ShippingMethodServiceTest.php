<?php

use App\Business\Services\ShippingMethodService;
use App\Zone;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShippingMethodServiceTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function find_shipping_method_by_total_cart_value()
    {
        //arrange
        /** @var Zone $zone */
        $zone = Zone::inState('B')->first();
        $shippingMethodService = new ShippingMethodService();

        //act
        $nonFreeShipping = $shippingMethodService->filterByPriceCondition($zone, 10);
        $freeShipping = $shippingMethodService->filterByPriceCondition($zone, 30);

        //assert
        $shippingMethods = $zone->shipping_methods()->get();
        $this->assertEquals($shippingMethods->shift(), $nonFreeShipping);
        $this->assertEquals($shippingMethods->shift(), $freeShipping);

    }
}
