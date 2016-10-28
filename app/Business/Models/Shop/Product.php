<?php

namespace App\Business\Models\Shop;

use App\Business\Traits\Presenters\ProductPresenter;
use App\Business\Traits\PublishedProductsTrait;
use App\Review;

/**
 * Class PublishedProduct
 * @package App\Shop
 *
 * @method featured($is_featured = true) Bool
 */
class Product extends \App\Product
{
    use PublishedProductsTrait, ProductPresenter;

    protected $appends = ['range_price', 'tags_list', 'currency'];

    const DRAFT_CLASS = 'bg-danger';
    const PUBLISHED_CLASS = 'bg-primary';
    const HIDDEN_CLASS = 'bg-info';

    /**
     * @return mixed
     */
    public function getReviewsVerifiedAttribute()
    {
        return $this->reviews()->filter(function($review) {
            return $review->verified;
        });
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
