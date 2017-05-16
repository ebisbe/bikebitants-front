<?php

namespace Tests\Unit;

use App\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    protected function tearDown()
    {
        Product::truncate();
    }

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

    /** @test */
    public function it_gets_collection_address()
    {
        /** @var Product $product */
        $product = factory(Product::class)->create([
            Product::ADDRESS => 'BIKEBITANTS',
            Product::ADDRESS_CASH_ON_DELIVERY => 'BIKEBITANTS CASH ON DELIVERY'
        ]);

        $this->assertEquals('BIKEBITANTS', $product->collectionAddress(false));
    }

    /** @test */
    public function it_gets_collection_address_cash_on_delivery()
    {
        /** @var Product $product */
        $product = factory(Product::class)->create([
            Product::ADDRESS => null,
            Product::ADDRESS_CASH_ON_DELIVERY => 'BIKEBITANTS',
        ]);

        $this->assertEquals('BIKEBITANTS', $product->collectionAddress(true));
    }

    /** @test */
    public function it_doesnt_gets_collection_address()
    {
        /** @var Product $product */
        $product = factory(Product::class)->create();

        $this->assertNull($product->collectionAddress(false));
        $this->assertNull($product->collectionAddress(true));
    }

    /** @test */
    public function it_gets_delivery_address()
    {
        /** @var Product $product */
        $product = factory(Product::class)->create([
           Product::DELIVERY_ADDRESS => 'BIKEBITANTS'
        ]);

        $this->assertEquals('BIKEBITANTS', $product->deliveryAddress());
    }
}
