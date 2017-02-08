<?php

namespace App;

use App\Business\Repositories\ProductRepository;
use App\Jobs\ProductVariations;
use Jenssegers\Mongodb\Eloquent\Model;

class Variation extends Model
{
    protected $fillable = ['_id', 'real_price', 'discounted_price', 'is_discounted', 'stock', 'external_id'];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($variation) {
            //TODO check for stock lower than 0 and deny it
            if ($variation->is_discounted) {
                $variation->price = $variation->discounted_price;
            } else {
                $variation->price = $variation->real_price;
            }
        });

        static::saved(function ($model) {
            /** @var Product $product */
            $product = (new ProductRepository())->find($model->_id[0]);
            dispatch(new ProductVariations($product));
        });
    }
}
