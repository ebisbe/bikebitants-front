<?php

namespace App;

use App\Jobs\ProductVariations;
use Jenssegers\Mongodb\Eloquent\Model;

class Variation extends Model
{
    protected $fillable = ['_id', 'real_price', 'discounted_price', 'is_discounted', 'stock'];

    public static function boot()
    {
        parent::boot();

        static::saving(function($variation) {
            if($variation->is_discounted) {
                $variation->price = $variation->discounted_price;
            } else {
                $variation->price = $variation->real_price;
            }
        });

        static::saved(function ($model) {
            $product = Product::find($model->_id[0]);
            dispatch(new ProductVariations($product));
        });

    }
}
