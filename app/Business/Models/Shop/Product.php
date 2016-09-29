<?php

namespace App\Business\Models\Shop;

use App\Business\Traits\PublishedProductsTrait;

/**
 * Class PublishedProduct
 * @package App\Shop
 *
 * @method featured($featured = true) Bool
 */
class Product extends \App\Product
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
