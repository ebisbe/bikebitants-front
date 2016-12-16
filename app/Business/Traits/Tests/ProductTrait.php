<?php

namespace App\Business\Traits\Tests;

trait ProductTrait
{
    public function addSimpleProduct($quantity = 1)
    {
        $this
            ->post('/api/cart', [
                'product_id' => "simple-product",
                'quantity' => $quantity
            ]);
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