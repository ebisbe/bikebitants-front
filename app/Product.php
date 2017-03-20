<?php

namespace App;

use App\Business\Traits\UpdateCategoriesTrait;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Business\Traits\SluggableTrait;
use Jenssegers\Mongodb\Eloquent\Builder;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

/**
 * Class Product
 * @package App
 *
 * @property string $_id
 * @property string $name
 * @property string $description
 * @property string $currency
 * @property string $html_currency
 * @property array $categories
 * @property Brand $brand
 * @property string $tags_list
 * @property-read Image $front_image
 * @property-read Image $front_image_hover
 * @property-read Category $category
 *
 * @method static Builder whereSlug($slug)
 * @method static Builder whereBrandId($brandId)
 */
class Product extends Model
{
    use SoftDeletes, SluggableTrait, UpdateCategoriesTrait;

    /** @var string $table Defined for inheritance in PublishedProduct */
    protected $table = 'products';

    const DRAFT = 1;
    const PUBLISHED = 2;
    const HIDDEN = 3;

    const LOW_STOCK = 5;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'generic_name',
        'slug',
        'status',
        'introduction',
        'description',
        'is_featured',
        'tags',
        'meta_title',
        'meta_description',
        'meta_slug',
        'external_id',
        'prices',
        'stock',
        'is_discounted',
        'categories',
        'rating'
    ];

    protected $attributes = [
        'categories' => []
    ];

    protected $casts = ['is_featured' => 'boolean', 'is_discounted' => 'boolean', 'review_allowed' => 'boolean'];

    /**
     * Colors defined for the product
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function properties()
    {
        return $this->embedsMany(Property::class);
    }

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function variations()
    {
        return $this->embedsMany(Variation::class);
    }

    /**
     * Reviews made by the users for the product
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function reviews()
    {
        return $this->embedsMany(Review::class);
    }

    /**
     * Labels attached to the product
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function labels()
    {
        return $this->embedsMany(Label::class);
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
     * Brand of the product
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function category()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function faqs()
    {
        return $this->embedsMany(Faq::class);
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
        return $this->stock <= self::LOW_STOCK;
    }
}
