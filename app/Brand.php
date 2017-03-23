<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;
use App\Business\Traits\SluggableTrait;
use Jenssegers\Mongodb\Eloquent\Builder;

/**
 * Class Brand
 * @package App
 *
 * @property string name
 * @property string title
 *
 * @method static Builder whereSlug($slug)
 * @method static Builder featured($is_featured = true)
 */
class Brand extends Model
{

    use SluggableTrait;
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'description', 'filename', 'is_featured', 'meta_title', 'meta_description', 'meta_slug'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function services()
    {
        return $this->embedsMany(BrandService::class);
    }

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
