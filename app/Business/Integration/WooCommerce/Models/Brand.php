<?php

namespace App\Business\Integration\WooCommerce\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Builder;

/**
 * Class Brand
 * @package App
 *
 * @property string _id
 * @property string name
 * @property string title
 * @property string meta_description
 * @property string filename
 *
 * @method static Builder whereSlug($slug)
 * @method static Builder featured($is_featured = true)
 */
class Brand extends Model
{

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'filename',
        'is_featured',
        'meta_title',
        'meta_description',
        'meta_slug'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
