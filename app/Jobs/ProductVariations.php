<?php

namespace App\Jobs;

use App\Business\Repositories\ProductRepository;
use App\Jobs\Job;
use App\Product;
use App\Variation;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;

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
        /** @var Collection $variations */
        $variations = $this->product->variations();

        $productRepository->update($this->product->_id, [
            'prices' => $variations->pluck('price')->unique()->values()->toArray(),
            'stock' => $this->stock($variations),
            'is_discounted' => $variations->where('is_discounted', true)->count() > 0
        ]);
    }

    /**
     * @param $variations
     * @return mixed
     */
    public function stock($variations)
    {
        $filtered = $variations->filter(function ($variation) {
            return is_numeric($variation->stock);
        });

        return $filtered->count() == 0 ? null : $filtered->sum('stock');
    }
}
