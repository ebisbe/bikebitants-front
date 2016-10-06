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
        $prices = $this->product->variations->map(function($variation) {
            /** @var Variation $variation */
            if($variation->is_discounted) {
                return $variation->discounted_price;
            }
            return $variation->price;
        })->toArray();
        $this->product->prices = $prices;

        $this->product->save();
    }
}
