<?php

namespace App;

use App\Business\Traits\UpdateCategoriesTrait;
use App\Business\Traits\SluggableTrait;
use Jenssegers\Mongodb\Eloquent\Builder;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

/**
 * Class Product
 * @package App
 *
 * @property string $_id
 * @property string $currency
 * @property string $html_currency
 * @property string $name
 * @property string $slug
 * @property string $status
 * @property string $introduction
 * @property string $description
 * @property string $is_featured
 * @property string $menu_order
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_slug
 * @property string $external_id
 * @property bool $reviews_allowed
 * @property array $prices
 * @property string $stock
 * @property boolean $is_discounted
 * @property array $categories
 * @property string $rating
 * @property Brand $brand
 * @property string $tags_list
 * @property-read Image $front_image
 * @property-read Image $front_image_hover
 * @property-read Category $category
 * @property-read Property $properties
 *
 * @method static Product whereSlug($slug)
 * @method static Product whereBrandId($brandId)
 * @method static Product hasStock()
 * @method static Product isVariable()
 */
class Product extends \App\Business\Integration\WooCommerce\Models\Product
{
    use SoftDeletes, SluggableTrait, UpdateCategoriesTrait;

    /** @var string $table Defined for inheritance in PublishedProduct */
    protected $table = 'products';

    const DRAFT = 1;
    const PUBLISHED = 2;
    const HIDDEN = 3;

    const LOW_STOCK = 5;


    /**
     * Labels attached to the product
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function labels()
    {
        return $this->embedsMany(Label::class);
    }


    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function faqs()
    {
        return $this->embedsMany(Faq::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function related()
    {
        return $this->belongsToMany(self::class, null, 'product_ids', 'related_ids');
    }

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function variations()
    {
        return $this->embedsMany(Variation::class);
    }

    /**
     * Images from the product
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function images()
    {
        return $this->embedsMany(Image::class);
    }

    /**
     * @param $properties
     * @return Variation
     */
    public function productVariation($properties)
    {
        return $this
            ->variations()
            ->first(function ($value) use ($properties) {
                return array_diff($value->_id, array_values($properties)) == [];
            });
    }

    /**
     * Get the price of a product. If has multiple attributes with different prices should work too.
     * @param array $properties
     * @return int
     */
    public function finalPrice($properties = [])
    {
        $variation = $this->productVariation($properties);
        return $variation->price;
    }

    /**
     * Checks if current product is under low stock
     * @return bool
     */
    public function hasLowStock()
    {
        return !is_null($this->stock) && $this->stock <= self::LOW_STOCK;
    }

    /**
     * @param Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHasStock(Builder $query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * @param Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsVariable(Builder $query)
    {
        return $query->whereNotNull('properties');
    }

    public function isDropShipping()
    {
        return is_null($this->stock);
    }
}
