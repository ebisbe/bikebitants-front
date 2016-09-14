<?php

namespace App\Shop;

use App\Business\Traits\PublishedProductsTrait;
use App\Product;

/**
 * Class PublishedProduct
 * @package App\Shop
 *
 * @method featured($featured = true) Bool
 */
class PublishedProduct extends Product
{
    use PublishedProductsTrait;

    /**
     * @param $query
     * @param bool $featured
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFeatured($query, $featured = true)
    {
        return $query->where('featured', (bool)$featured);
    }
}
