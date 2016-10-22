<?php

namespace App;

use App\Business\MongoEloquentModel as Model;
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
    use SoftDeletes, SluggableTrait;

    /** @var string $table Defined for inheritance in PublishedProduct */
    protected $table = 'products';

    const DRAFT = 1;
    const PUBLISHED = 2;
    const HIDDEN = 3;

    const DRAFT_CLASS = 'bg-danger';
    const PUBLISHED_CLASS = 'bg-primary';
    const HIDDEN_CLASS = 'bg-info';

    protected $appends = ['range_price', 'tags_list', 'currency'];
    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'generic_name', 'slug', 'status', 'introduction', 'description', 'is_featured', 'tags', 'meta_title', 'meta_description', 'meta_slug', 'external_id', 'prices', 'stock', 'is_discounted'];
    protected $casts = ['is_featured' => 'boolean', 'is_discounted' => 'boolean'];

    /**
     * Get a single point to find a price. The product can be a variable or simple
     * @return string
     */
    public function getRangePriceAttribute()
    {
        $min = $this->variations->min('price');
        $max = $this->variations->max('price');
        if ($min != $max) {
            return $min . $this->currency . ' - ' . $max . $this->currency;
        }
        return $min . $this->currency;
    }

    /**
     * Get a single point to find a price. The product can be a variable or simple
     * @return string
     */
    public function getRangeRealPriceAttribute()
    {
        $min = $this->variations->min('real_price');
        $max = $this->variations->max('real_price');
        if ($min != $max) {
            return $min . $this->currency . ' - ' . $max . $this->currency;
        }
        return $min . $this->currency;
    }

    public function getStatusTextAttribute()
    {
        return trans('Product.' . $this->status);
    }

    /**
     * While we have just one currency we set a default value.
     * @return string
     */
    public function getCurrencyAttribute()
    {
        return '&euro;';
    }

    /**
     * Convert tags array into a comma list.
     * @return string
     */
    public function getTagsListAttribute()
    {
        return is_array($this->tags) ? implode(', ', $this->tags) : $this->tags;
    }

    public function setIsFeaturedAttribute($featured)
    {
        $this->attributes['is_featured'] = (bool)$featured;
    }

    public function setIsDiscountedAttribute($is_discounted)
    {
        $this->attributes['is_discounted'] = (bool)$is_discounted;
    }

    /**
     * @return Image|null
     */
    public function getFrontImageAttribute()
    {
        return static::images()->first();
    }

    /**
     * @return Image|null
     */
    public function getFrontImageHoverAttribute()
    {
        return static::images()->slice(1, 1)->first();
    }

    /**
     * Colors defined for the product
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function attributes()
    {
        return $this->embedsMany(Attribute::class);
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function faqs()
    {
        return $this->embedsMany(Faq::class);
    }

    /**
     * @param $attributes
     * @return Product
     */
    public function productVariation($attributes)
    {
        return $this
            ->variations()
            ->first(function ($key, $value) use ($attributes) {
                return array_diff($value->_id, array_values($attributes)) == [];
            });
    }

    /**
     * Get the price of a product. If has multiple attributes with different prices should work too.
     * @param array $attributes
     * @return int
     */
    public function finalPrice($attributes = [])
    {
        $variation = $this->productVariation($attributes);
        return $variation->price;
    }
}
