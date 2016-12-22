<?php

namespace App\Business\Traits\Tests;

trait ProductTrait
{
    public function addSimpleProduct($quantity = 1)
    {
        $this
            ->postJson('/api/cart', [
                'product_id' => "simple-product",
                'quantity' => $quantity
            ]);

        return $this;
    }

    public function getProductResponse()
    {
        return [
            'filename',
            'alt',
            'name',
            'is_max_stock',
            'route',
            'quantity',
            'price',
            'currency',
            '_id',
        ];
    }
}