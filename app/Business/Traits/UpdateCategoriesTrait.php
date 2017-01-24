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
            $categories = [];
            /** @var Category $category */
            $category = $product->category()->first();

            if (is_null($category)) {
                return ;
            }

            if (!empty($category->father->slug)) {
                $categories[] = $category->father->slug;
            }

            $categories[] = $category->slug;
            $product->categories = $categories;
        });
    }
}
