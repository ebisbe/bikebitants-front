<?php

namespace App\Business\Models\Shop;

/**
 * Class Category
 * @package App\Shop
 *
 */
class Tag extends \App\Tag
{
    public function products_shop()
    {
        return $this->belongsToMany(Product::class);
    }
}
