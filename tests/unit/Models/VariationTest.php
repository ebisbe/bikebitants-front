<?php

namespace Tests\Unit\Models;

use App\Cart;
use App\Order;
use App\Variation;
use Event;
use Illuminate\Support\Collection;
use Tests\TestCase;

class VariationTest extends TestCase
{
    /** @test */
    public function it_decrements_real_stock()
    {
        Event::fake();
        /** @var Variation $variation */
        $variation = factory(Variation::class)->create(['stock' => 5]);

        $this->assertSame(5, $variation->stock);

        $variation->updateStock(2, Order::NEW);

        $this->assertSame(3, $variation->stock);
    }

    /** @test */
    public function it_increments_real_stock()
    {
        Event::fake();
        /** @var Variation $variation */
        $variation = factory(Variation::class)->create(['stock' => 5]);

        $this->assertSame(5, $variation->stock);

        $variation->updateStock(2, Order::CANCELLED);

        $this->assertSame(7, $variation->stock);
    }

    /** @test */
    public function it_decrements_dropshipping_stock()
    {
        Event::fake();
        /** @var Variation $variation */
        $variation = factory(Variation::class)->create(['stock' => null]);

        $this->assertSame(null, $variation->stock);

        $variation->updateStock(2, Order::NEW);

        $this->assertSame(null, $variation->stock);
    }

    /** @test */
    public function it_increments_dropshipping_stock()
    {
        Event::fake();
        /** @var Variation $variation */
        $variation = factory(Variation::class)->create(['stock' => null]);

        $this->assertSame(null, $variation->stock);

        $variation->updateStock(2, Order::CANCELLED);

        $this->assertSame(null, $variation->stock);
    }
}
