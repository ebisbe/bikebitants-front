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
    const CORREOS_24 = 'correos-24';

    /** @var  Shipment */
    private $shipment;

    protected function setUp()
    {
        $this->shipment = new Shipment();
        parent::setUp();
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

    public function it_sends_a_shipment_to_deliverea()
    {
        Event::fake();
        /** @var Order $order */
        $order = factory(Order::class)->states('CashOnDelivery')->create();

        $this->shipment->order($order);
        $this->shipment->process();
    }

    /** @test */
    public function it_recieves_addresse()
    {
        $address = $this->shipment->addressData('PROVA1');

        $this->assertInstanceOf(Deliverea\Model\Address::class, $address);
        $this->assertEquals('prova1', $address->getName());
    }
}
