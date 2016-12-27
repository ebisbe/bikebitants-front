<?php

namespace App\Business\Traits\Tests;

use App\Business\Models\Shop\Product;
use App\Tax;
use App\Variation;

trait ProductTrait
{
    /**
     * @return Product
     */
    public function createSimpleProduct()
    {
        $product = factory(Product::class)->create(['_id' => 'simple-product']);
        $variation = factory(Variation::class)->make([
            '_id' => [$product->_id],
            'real_price' => 10,
            'is_discounted' => false,
            'stock' => 10
        ]);
        $product->variations()->save($variation);

        return $product;
    }

    public function createProductWithThreeVariations()
    {
        /** @var Product $product */
        $product = factory(Product::class)->create();
        $variation1 = factory(Variation::class)->make([
            '_id' => [$product->_id],
            'real_price' => 10,
            'is_discounted' => false
        ]);
        $variation2 = factory(Variation::class)->make([
            '_id' => [$product->_id],
            'real_price' => 15,
            'is_discounted' => false
        ]);
        $variation3 = factory(Variation::class)->make([
            '_id' => [$product->_id],
            'real_price' => 20,
            'is_discounted' => false
        ]);
        $product->variations()->saveMany([$variation1, $variation2, $variation3]);

        return Product::find($product->_id);
    }

    public function createTax(int $rate = 0)
    {
        factory(Tax::class)->create([
            'country' => '',
            'state' => '',
            'postcode' => '',
            'city' => '',
            'rate' => $rate,
            'name' => 'Iva',
            'order' => 1,
        ]);
    }

    public function addSimpleProduct(int $quantity = 1)
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