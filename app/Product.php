<?php

namespace App;

use App\Business\MongoEloquentModel as Model;

class Product extends Model
{

    public function getTagsArray()
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
     * Get the price of a product. If has multiple attributes with different prices should work too.
     * @param $product_id
     * @param array $attributes
     * @return int
     */
    public static function getPrice($product_id, $attributes = [])
    {
        /** @var Product $product */
        $product = self::where('_id', $product_id)->firstOrFail();
        $variation = $product
            ->variation()
            ->first(function ($key, $value) use($attributes) {
                return array_diff($value->_id, array_values($attributes) ) == [];
            });
        if (!empty($variation)) {
            $product = $variation;
        }

        return $product->price;
    }
}
