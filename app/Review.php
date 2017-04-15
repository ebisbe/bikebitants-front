<?php

namespace App;

use App\Business\Repositories\ProductRepository;
use App\Jobs\ProductReviewRating;

class Review extends \App\Business\Integration\WooCommerce\Models\Review
{
    public static function boot()
    {
        parent::boot();

        static::saved(function ($review) {
            /** @var Product $product */
            $product = Product::find($review->product_id);
            dispatch(new ProductReviewRating($product));
        });
    }
}
