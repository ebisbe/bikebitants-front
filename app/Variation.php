<?php

namespace App;

use App\Jobs\ProductVariationsPrices;
use Jenssegers\Mongodb\Eloquent\Model;

class Variation extends Model
{
    protected $fillable = ['_id', 'price'];

    public static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            $product = Product::find($model->_id[0]);
            dispatch(new ProductVariationsPrices($product));
        });

    }
}
