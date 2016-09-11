<?php

namespace App;

use App\Business\MongoEloquentModel as Model;
use Jenssegers\Mongodb\Eloquent\Builder;

/**
 * Class Product
 * @package App
 *
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
    /** @var string $table Defined for inheritance in PublishedProduct */
    protected $table = 'products';

    const DRAFT = 1;
    const PUBLISHED = 2;
    const HIDDEN = 3;

    const DRAFT_CLASS = 'bg-danger';
    const PUBLISHED_CLASS = 'bg-primary';
    const HIDDEN_CLASS = 'bg-info';

    protected $appends = ['range_price', 'tags_list', 'currency'];

    protected $fillable = ['name', 'slug', 'status', 'introduction', 'description', 'meta_title', 'meta_description', 'meta_slug'];

    /**
     * Get a single point to find a price. The product can be a variable or simple
     * @return string
     */
    public function getRangePriceAttribute()
    {
        $price = $this->price;
        if (!empty($this->variation()->count())) {
            $min = $this->variation->min('price');
            $max = $this->variation->max('price');
            if ($min != $max) {
                return $min . $this->currency . ' - ' . $max . $this->currency;
            }
            $price = $min;
        }
        return $price . $this->currency;
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
        return ' &euro;';
    }

    /**
     * Convert tags array into a comma list.
     * @return string
     */
    public function getTagsListAttribute()
    {
        return implode(', ', $this->tags);
    }

    /**
     * @return Image|null
     */
    public function getFrontImageAttribute()
    {
        return self::images()->first();
    }

    /**
     * @return Image|null
     */
    public function getFrontImageHoverAttribute()
    {
        return self::images()->slice(1, 1)->first();
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
    public function variation()
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
            ->variation()
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
        if ($this->variation()->count()) {
            $variation = $this->productVariation($attributes);
            return $variation->price;
        }

        return $this->price;
    }
}
