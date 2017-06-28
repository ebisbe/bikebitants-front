<?php

namespace Tests\Unit\Models;

use App\Order;
use App\PaymentMethod;
use Tests\TestCase;
use Event;

class OrderTest extends TestCase
{
    /** @test */
    public function it_is_shipping_to_barcelona()
    {
        Event::fake();
        /** @var Order $order */
        $order = factory(Order::class)->create([
            'shipping' => [
                'country' => 'ES',
                'state' => 'B'
            ]
        ]);

        $this->assertTrue($order->isShippingToBarcelona());
    }

    /** @test */
    public function it_is_shipping_to_lleida()
    {
        Event::fake();
        /** @var Order $order */
        $order = factory(Order::class)->create([
            'shipping' => [
                'country' => 'ES',
                'state' => 'L'
            ]
        ]);

        $this->assertFalse($order->isShippingToBarcelona());
    }

    /** @test */
    public function it_is_shipping_to_girona()
    {
        Event::fake();
        /** @var Order $order */
        $order = factory(Order::class)->create([
            'shipping' => [
                'country' => 'ES',
                'state' => 'GI'
            ]
        ]);

        $this->assertFalse($order->isShippingToBarcelona());
    }

    /** @test */
    public function it_is_shipping_to_tarragona()
    {
        Event::fake();
        /** @var Order $order */
        $order = factory(Order::class)->create([
            'shipping' => [
                'country' => 'ES',
                'state' => 'T'
            ]
        ]);

        $this->assertFalse($order->isShippingToBarcelona());
    }

    /** @test */
    public function it_is_not_shipping_to_catalunya()
    {
        Event::fake();
        /** @var Order $order */
        $order = factory(Order::class)->create([
            'shipping' => [
                'country' => 'ES',
                'state' => 'AL'
            ]
        ]);

        $this->assertFalse($order->isShippingToBarcelona());
    }

    /** @test */
    public function it_is_a_cash_on_delivery()
    {
        Event::fake();
        $order = factory(Order::class)->create([
            'payment_method_id' => factory(PaymentMethod::class)->lazy([
                'slug' => 'cash-on-delivery'
            ])
        ]);

        $this->assertTrue($order->isCashOnDelivery());
    }

    /** @test */
    public function it_is_not_a_cash_on_delivery()
    {
        Event::fake();
        $order = factory(Order::class)->create([
            'payment_method_id' => factory(PaymentMethod::class)->lazy([
                'slug' => 'paypal'
            ])
        ]);

        $this->assertFalse($order->isCashOnDelivery());
    }
}
