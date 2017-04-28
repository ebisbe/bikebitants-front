<?php

namespace App;

use App\Jobs\ProductReviewRating;
use App\Jobs\PushReview;

class Review extends \App\Business\Integration\WooCommerce\Models\Review
{
    public static function boot()
    {
        parent::boot();

        static::saved(function ($review) {
            /** @var Product $product */
            $product = Product::find($review->product_id);
            dispatch(new ProductReviewRating($product));

            if (empty($review->external_id)) {
                dispatch(new PushReview($review));
            }
        });
    }
}
