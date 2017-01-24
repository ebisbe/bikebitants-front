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

        $product->properties->each(function ($property) use ($dupProduct) {
            /** @var Attribute $attribute */
            $dupAtt = $dupProduct->properties()->create($property->toArray());
            $dupAtt->property_values()->createMany($property->property_values);
        });

        $dupProduct->properties()->createMany($product->property->toArray());
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
