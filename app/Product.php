<?php

namespace App;

use App\Business\MongoEloquentModel as Model;
use Jenssegers\Mongodb\Eloquent\Builder;

/**
 * Class Product
 * @package App
 *
 * @property string name
 * @property string description
 * @property string currency
 * @property Brand brand
 * @property string tags_list
 *
 * @method static Builder whereSlug($slug)
 * @method static Builder whereBrandId($brandId)
 */
class Product extends Model
{


    protected $appends = ['range_price', 'tags_list', 'currency', 'final_price'];

    /**
     * Get a single point to find a price. The product can be a variable or simple
     * @return string
     */
    public function getRangePriceAttribute()
    {
        if (!empty($this->variation()->count())) {
            $min = $this->variation->min('price');
            $max = $this->variation->max('price');
            return $min . $this->currency . ' - ' . $max . $this->currency;
        } else {
            return $this->price . $this->currency;
        }
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
     * Get the price of a product. If has multiple attributes with different prices should work too.
     * @param array $attributes
     * @return int
     */
    public function finalPrice($attributes = [])
    {
        if ($this->variation()->count()) {

            /** @var Product $product */
            $variation = $this
                ->variation()
                ->first(function ($key, $value) use ($attributes) {
                    return array_diff($value->_id, array_values($attributes)) == [];
                });
            if (!empty($variation)) {
                $product = $variation;
            }
            return $product->price;
        }

        return $this->price;
    }
}
