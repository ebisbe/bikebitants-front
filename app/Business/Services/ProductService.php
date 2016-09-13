<?php

namespace App\Business\Services;

use App\Product;

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
}