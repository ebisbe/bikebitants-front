<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Product;
use App\Variation;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProductVariationsPrices extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    var $product;

    /**
     * ProductVariationsPrices constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->product->prices = $this->product
            ->variations
            ->map(function ($variation) {
                return $variation->price;
            })->toArray();


        $this->product->is_discounted = $this->product
                ->variations
                ->filter(function ($variation) {
                    return $variation->is_discounted;
                })->count() > 0;

        $this->product->save();
    }
}
