<?php

namespace Tests\Unit\Models;

use App\Cart;
use App\Order;
use App\Shipment;
use App\Variation;
use Event;
use Illuminate\Support\Collection;
use Tests\TestCase;

class VariationTest extends TestCase
{
    /** @test */
    public function it_decrements_real_stock()
    {
        /** @var Shipment $shipment */
        $shipment = factory(Shipment::class)->create(['notify_to' => ['email1@inet.com', 'email2@inet.net']]);
        $this->assertSame('email1@inet.com,email2@inet.net', $shipment->notify_to_list);
    }
}
