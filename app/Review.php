<?php

namespace App;

use App\Business\MongoEloquentModel as Model;
use App\Business\Repositories\ProductRepository;
use App\Jobs\ProductReviewRating;

class Review extends Model
{

    protected $fillable = [ 'external_id', 'name', 'email', 'comment', 'verified', 'rating', 'product_id' ];

    protected $attributes = [
        'verified' => false
    ];

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::saved(function ($review) {
            /** @var Product $product */
            $product = (new ProductRepository())->find($review->product_id);
            dispatch(new ProductReviewRating($product));

        });
    }

    /**
     * Comments on a comment
     *
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function children()
    {
        return $this->embedsMany(Review::class);
    }
}
