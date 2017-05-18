<?php

namespace Tests\Unit\Models;

use App\Order;
use App\PaymentMethod;
use Tests\TestCase;
use Event;

class OrderTest extends TestCase
{
    /** @test */
    public function it_is_shipping_to_catalunya()
    {
        Event::fake();
        $order = factory(Order::class)->create([
            'shipping' => [
                'country' => 'ES',
                'state' => 'C'
            ]
        ]);

        $this->assertTrue($order->isShippingToCatalunya());
    }

    /** @test */
    public function it_is_not_shipping_to_catalunya()
    {
        Event::fake();
        $order = factory(Order::class)->create([
            'shipping' => [
                'country' => 'ES',
                'state' => 'AL'
            ]
        ]);

        $this->assertFalse($order->isShippingToCatalunya());
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
