<?php

namespace Tests\Feature;

use App\Business\Repositories\ProductRepository;
use App\Business\Traits\Tests\ProductTrait;
use App\Jobs\ProductVariations;
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
        $product = $this->createProductWithThreeVariations([10,15,20], false);
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
}