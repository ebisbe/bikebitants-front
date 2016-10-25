<?php

namespace App\Business\Services;

use App\Product;
use App\Variation;

class ProductService
{
    public static function duplicate($id)
    {
        $product = Product::findOrFail($id);

        $product->unset('_id');
        $product->slug .= '-' . rand(0, 1000);
        $product->status = Product::DRAFT;

        /** @var Product $product */
        $dupProduct = Product::create($product->toArray());

        $product->attributes->each(function ($attribute) use ($dupProduct) {
            /** @var Attribute $attribute */
            $dupAtt = $dupProduct->attributes()->create($attribute->toArray());
            $dupAtt->attribute_values()->createMany($attribute->attribute_values);
        });

        $dupProduct->attributes()->createMany($product->attributes->toArray());
        $dupProduct->variations()->createMany($product->variations->toArray());
        $dupProduct->reviews()->createMany($product->reviews->toArray());
        $dupProduct->labels()->createMany($product->labels->toArray());
        $dupProduct->images()->createMany($product->images->toArray());
        $dupProduct->faqs()->createMany($product->faqs->toArray());

        if ($brand = $product->brand()->first()) {
            $brand->products()->save($dupProduct);
        }
        if ($category = $product->category()->first()) {
            $category->products()->save($dupProduct);
        }

        return true;
    }

    /**
     * @param $attributes
     * @return Variation
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