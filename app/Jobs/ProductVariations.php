<?php

namespace App\Jobs;

use App\Business\Repositories\ProductRepository;
use App\Jobs\Job;
use App\Product;
use App\Variation;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProductVariations extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    /**
     * @var Product
     */
    private $product;


    /**
     * ProductVariationsPrices constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * @param ProductRepository $productRepository
     */
    public function handle(ProductRepository $productRepository)
    {
        $variations = $this->product->variations();

        $productRepository->update($this->product, [
            'prices' => $variations->pluck('price')->unique()->values()->toArray(),
            'stock' => $variations->sum('stock'),
            'is_discounted' => $variations->where('is_discounted', true)->count() > 0
        ]);
    }
}
