<?php

namespace Tests\Unit;

use App\Business\Deliverea\Shipment;
use App\Order;
use Deliverea;
use Tests\TestCase;
use Event;

class ShipmentTest extends TestCase
{
    const OVIRTUAL = 'ovirtual';
    const OVIRTUAL_ENTREGA_OFICINA = 'ovirtual-servicio-19';

    const CORREOS_EXPRESS = 'correosExpress';
    const CORREOS_24 = 'correos-epaq-24';

    /** @var  Shipment */
    private $shipment;

    protected function setUp()
    {
        $this->shipment = new Shipment();
        parent::setUp();
    }

    /** @test */
    public function it_is_an_order_with_collect_at_almogavers_and_deliver_bcn()
    {
        $carrier = $this->shipment->getCarrier(true, 'BIKEBITANTS ALMOGAVERS');

        $this->assertEquals(self::CORREOS_EXPRESS, $carrier->name());
        $this->assertEquals(self::CORREOS_24, $carrier->service());
    }

    /** @test */
    public function it_is_an_order_with_collect_at_almogavers_and_deliver_outside_bcn()
    {
        $carrier = $this->shipment->getCarrier(false, 'BIKEBITANTS ALMOGAVERS');

        $this->assertEquals(self::OVIRTUAL, $carrier->name());
        $this->assertEquals(self::OVIRTUAL_ENTREGA_OFICINA, $carrier->service());
    }

    /** @test */
    public function it_is_an_order_with_deliver_outside_bcn()
    {
        $carrier = $this->shipment->getCarrier(false, 'PROVA1');

        $this->assertEquals(self::OVIRTUAL, $carrier->name());
        $this->assertEquals(self::OVIRTUAL_ENTREGA_OFICINA, $carrier->service());
    }

    /** @test */
    public function it_is_an_order_with_collect_at_alomgavers_and_deliver_bcn()
    {
        $carrier = $this->shipment->getCarrier(true, 'PROVA1');

        $this->assertEquals(self::OVIRTUAL, $carrier->name());
        $this->assertEquals(self::OVIRTUAL_ENTREGA_OFICINA, $carrier->service());
    }
}
