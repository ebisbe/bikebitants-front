<?php

namespace Tests\Feature;

use App\Business\Checkout\Events\Confirm;
use App\Listeners\NotifySaleToProvider;
use App\Order;
use App\Product;
use Tests\TestCase;

class NotifySaleToProviderTest extends TestCase
{

    protected function tearDown()
    {
        Order::truncate();
        Product::truncate();
        parent::tearDown();
    }

    /** @test */
    public function it_notifies_the_provider()
    {
        /** @var Order $order */
        $order = factory(Order::class)->states('DropShippingWithCarrierProvider')->create();
        //'discount_end' => $faker->date(),
        $confirm = new Confirm($order);

        $notifySale = new NotifySaleToProvider();
        $notifySale->handle($confirm);
    }
}
