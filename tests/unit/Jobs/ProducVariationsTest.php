<?php

namespace Tests\Feature;

use App\Business\Repositories\ProductRepository;
use App\Business\Traits\Tests\ProductTrait;
use App\Jobs\ProductVariations;
use App\Variation;
use Tests\TestCase;
use Mockery;

class ProducVariationsTest extends TestCase
{
    use ProductTrait;

    /** @test */
    public function it_saves_an_array_of_prices()
    {
        $product = $this->createProductWithThreeVariations();

        $job = new ProductVariations($product);

        $productRepository = Mockery::mock(ProductRepository::class);
        $productRepository
            ->shouldReceive('update')
            ->with(
                'variation-product',
                [
                    'prices' => [10, 15, 20],
                    'stock' => 30,
                    'is_discounted' => false
                ]
            );

        $job->handle($productRepository);
    }

    /** @test */
    public function it_calculates_stock()
    {
        $product = $this->createProductWithThreeVariations([10, 15, 20], false);
        $job = new ProductVariations($product);

        $productRepository = Mockery::mock(ProductRepository::class);
        $productRepository
            ->shouldReceive('update')
            ->with(
                'variation-product',
                [
                    'prices' => [10, 15, 20],
                    'stock' => null,
                    'is_discounted' => false
                ]
            );

        $job->handle($productRepository);
    }

    /** @test */
    public function it_calculates_stock_with_mixing_product()
    {
        $product = $this->createProductWithThreeVariations([10, 15, 20], false);
        $job = new ProductVariations($product);


        $total = $job->stock(collect(
            [
                factory(Variation::class)->make(['stock' => 3]),
                factory(Variation::class)->make(['stock' => 7]),
                factory(Variation::class)->make(['stock' => null]),
                factory(Variation::class)->make(['stock' => null]),
                factory(Variation::class)->make(['stock' => null]),
                factory(Variation::class)->make(['stock' => null]),
                factory(Variation::class)->make(['stock' => null]),
                factory(Variation::class)->make(['stock' => null]),
                factory(Variation::class)->make(['stock' => null]),
                factory(Variation::class)->make(['stock' => null]),
                factory(Variation::class)->make(['stock' => null]),
                factory(Variation::class)->make(['stock' => null]),
            ]
        ));

        $this->assertEquals(10, $total);
    }

    /** @test */
    public function it_calculates_stock_with_dropshipping_stock()
    {
        $product = $this->createProductWithThreeVariations([10, 15, 20], false);
        $job = new ProductVariations($product);


        $total = $job->stock(collect(
            [
                factory(Variation::class)->make(['stock' => null]),
                factory(Variation::class)->make(['stock' => null]),
                factory(Variation::class)->make(['stock' => null]),
                factory(Variation::class)->make(['stock' => null]),
                factory(Variation::class)->make(['stock' => null]),
                factory(Variation::class)->make(['stock' => null]),
            ]
        ));

        $this->assertNull($total);
    }

    /** @test */
    public function it_calculates_stock_with_our_stock()
    {
        $product = $this->createProductWithThreeVariations([10, 15, 20], false);
        $job = new ProductVariations($product);


        $total = $job->stock(collect(
            [
                factory(Variation::class)->make(['stock' => 1]),
                factory(Variation::class)->make(['stock' => 2]),
                factory(Variation::class)->make(['stock' => 3]),
                factory(Variation::class)->make(['stock' => 4]),
                factory(Variation::class)->make(['stock' => 5]),
                factory(Variation::class)->make(['stock' => 6]),
            ]
        ));

        $this->assertEquals(21, $total);
    }
}