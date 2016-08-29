<?php

namespace App;

use App\Business\MongoEloquentModel as Model;
use Jenssegers\Mongodb\Eloquent\Builder;

/**
 * Class Brand
 * @package App
 *
 * @property string name
 *
 * @method static Builder whereSlug($slug)
 * @method static Builder featured()
 */
class Brand extends Model
{
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'description', 'filename', 'featured', 'meta_title', 'meta_description', 'meta_keywords'];

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
     * Scope a query to only include popular users.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFeatured($query)
    {
        /** @var Builder $query */
        return $query->where('featured', true);
    }
}
