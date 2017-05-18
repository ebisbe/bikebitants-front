<?php

namespace Tests\Unit;

use App\Business\Deliverea\Shipment;
use App\Order;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShipmentTest extends TestCase
{
    const OVIRTUAL = 'ovirtual';
    const OVIRTUAL_ENTREGA_OFICINA = 'ovirtual-entrega-oficina';

    const CORREOS_EXPRESS = 'correosExpress';
    const CORREOS_24 = 'correos-24';

    /** @var  Shipment */
    private $shipment;

    protected function setUp()
    {
        $this->shipment = new Shipment();
    }

    /**
     * @test
     * CASE 1
     */
    public function it_is_an_order_with_no_catalunya_has_stock_no_cash_on_delivery()
    {

        $carrier = $this->shipment->getCarrier(false, false, false);

        $this->assertEquals(self::OVIRTUAL, $carrier->name());
        $this->assertEquals(self::OVIRTUAL_ENTREGA_OFICINA, $carrier->service());
    }

    /**
     * @test
     * CASE 2
     */
    public function it_is_an_order_with_no_cash_on_delivery_dropshipping()
    {
        $carrier = $this->shipment->getCarrier(true, false, false);

        $this->assertEquals(self::OVIRTUAL, $carrier->name());
        $this->assertEquals(self::OVIRTUAL_ENTREGA_OFICINA, $carrier->service());

        $carrier = $this->shipment->getCarrier(true, false, true);

        $this->assertEquals(self::OVIRTUAL, $carrier->name());
        $this->assertEquals(self::OVIRTUAL_ENTREGA_OFICINA, $carrier->service());
    }

    /**
     * @test
     * CASE 4a
     */
    public function it_is_an_order_with_catalunya_has_stock_no_cash_on_delivery()
    {

        $carrier = $this->shipment->getCarrier(false, false, true);

        $this->assertEquals(self::CORREOS_EXPRESS, $carrier->name());
        $this->assertEquals(self::CORREOS_24, $carrier->service());
    }

    /**
     * @test
     * CASE 4b
     */
    public function it_is_an_order_with_cash_on_delivery_no_dropshipping()
    {
        $carrier = $this->shipment->getCarrier(false, true, true);

        $this->assertEquals(self::CORREOS_EXPRESS, $carrier->name());
        $this->assertEquals(self::CORREOS_24, $carrier->service());

        $carrier = $this->shipment->getCarrier(false, true, false);

        $this->assertEquals(self::CORREOS_EXPRESS, $carrier->name());
        $this->assertEquals(self::CORREOS_24, $carrier->service());
    }
     /**
      * @test
      * CASE 5
      */
     public function it_is_an_order_with_cash_on_delivery_dropshipping()
     {
         $carrier = $this->shipment->getCarrier(true, true, true);

         $this->assertEquals(self::CORREOS_EXPRESS, $carrier->name());
         $this->assertEquals(self::CORREOS_24, $carrier->service());

         $carrier = $this->shipment->getCarrier(true, true, false);

         $this->assertEquals(self::CORREOS_EXPRESS, $carrier->name());
         $this->assertEquals(self::CORREOS_24, $carrier->service());
     }
}
