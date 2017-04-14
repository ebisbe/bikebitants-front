<?php

namespace App;

use App\Business\Traits\SluggableTrait;

class Brand extends \App\Business\Integration\WooCommerce\Models\Brand
{
    use SluggableTrait;

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    /*public function services()
    {
        return $this->embedsMany(BrandService::class);
    }*/

    /**
     * @param $query
     * @param bool $is_featured
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFeatured($query, $is_featured = true)
    {
        /** @var Builder $query */
        return $query->where('is_featured', $is_featured);
    }

    /**
     * @return string
     */
    public function getTitleAttribute()
    {
        return ucfirst($this->name) . '. Tienda online | Bikebitants';
    }
}
