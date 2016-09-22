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
        /*$prices = $this->product->variations->map(function($variation) {
            //todo check if price is discounted and add that price instead
            return $variation->price;
        })->toArray();
        $this->product->prices = $prices;*/
        $this->product->min_price = $this->product->variations()->min('price');
        $this->product->max_price = $this->product->variations()->max('price');

        $this->product->save();
    }
}
