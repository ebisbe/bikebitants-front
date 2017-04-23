<?php

namespace App\Business\Models\Shop;

use App\Business\Traits\FilterPublishedTrait;
use App\Business\Traits\Presenters\ProductPresenter;

/**
 * Class PublishedProduct
 * @package App\Shop
 *
 * @method featured($is_featured = true) Bool
 */
class Product extends \App\Product
{
    use FilterPublishedTrait, ProductPresenter;

    protected $appends = ['range_price', 'tags_list', 'currency'];

    const DRAFT_CLASS = 'bg-danger';
    const PUBLISHED_CLASS = 'bg-primary';
    const HIDDEN_CLASS = 'bg-info';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function up_sell_shop()
    {
        return $this->belongsToMany(self::class, null, 'up_sell_ids');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cross_sell_shop()
    {
        return $this->belongsToMany(self::class, null, 'cross_sell_ids');
    }

    /**
     * @return mixed
     */
    public function getReviewsVerifiedAttribute()
    {
        return $this->reviews()->filter(function ($review) {
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
