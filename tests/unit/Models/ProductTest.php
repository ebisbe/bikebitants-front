<?php

namespace Tests\Unit;

use App\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /** @test */
    public function it_is_dropshipping_product()
    {
        $product = factory(Product::class)->create([
            'stock' => null
        ]);

        $this->assertTrue($product->isDropShipping());
    }

    /** @test */
    public function it_is_not_dropshipping_product()
    {
        $product = factory(Product::class)->create([
            'stock' => 100
        ]);

        $this->assertFalse($product->isDropShipping());
    }
}
