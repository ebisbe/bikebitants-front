<?php

namespace App\Business\Traits;

use App\Category;
use App\Product;

trait UpdateCategoriesTrait
{
    public static function bootUpdateCategoriesTrait()
    {
        static::saving(function ($product) {
            /** @var Product $product */
            $categories = collect();
            $product->category->each(function ($category) use ($categories) {
                /** @var Category $category */
                $categories->push($category->slug);
                if (!empty($category->father->slug)) {
                    $categories->push($category->father->slug);
                }
            });

            $product->categories = $categories->unique()->toArray();
        });
    }
}
