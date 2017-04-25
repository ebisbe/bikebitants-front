<?php

namespace Tests\Unit;

use App\Business\Services\ShippingMethodService;
use App\Business\Traits\Tests\ProductTrait;
use App\ShippingMethod;
use App\Zone;
use Tests\TestCase;

class ShippingMethodServiceTest extends TestCase
{
    use ProductTrait;

    /** @test */
    //TODO should compare with IVA
    public function find_shipping_method_by_total_cart_value()
    {
        //arrange
        $this->createZone();

        /** @var Zone $zone */
        $zone = Zone::inState('B')->first();
        $shippingMethodService = new ShippingMethodService();

        //act
        $nonFreeShipping = $shippingMethodService->filterByPriceCondition($zone, 10);

        //assert
        $this->assertFalse($nonFreeShipping->free_shipping);
    }
    /** @test */
    public function find_free_shipping_method_by_total_cart_value()
    {
        //arrange
        $this->createZone();

        /** @var Zone $zone */
        $zone = Zone::inState('B')->first();
        $shippingMethodService = new ShippingMethodService();

        //act
        $freeShipping = $shippingMethodService->filterByPriceCondition($zone, 30);

        //assert
        $this->assertTrue($freeShipping->free_shipping);
    }
}
