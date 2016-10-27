<?php

namespace App\Business\Models\Shop;

use App\Business\Traits\PublishedProductsTrait;

/**
 * Class PublishedProduct
 * @package App\Shop
 *
 * @method featured($is_featured = true) Bool
 */
class Product extends \App\Product
{
    use PublishedProductsTrait;

    /**
     * Reviews made by the users for the product
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function reviewsValidated()
    {
        return $this->embedsMany(Review::class);
    }

    /**
     * @param $query
     * @param bool $is_featured
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFeatured($query, $is_featured = true)
    {
        return $query->where('is_featured', (bool)$is_featured);
    }
}
