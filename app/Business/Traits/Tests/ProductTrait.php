<?php

namespace App\Business\Traits\Tests;

use App\Brand;
use App\Business\Models\Shop\Product;
use App\Coupon;
use App\Tax;
use App\Variation;

trait ProductTrait
{
    /**
     * @return Product
     */
    public function createSimpleProduct()
    {
        $product = factory(Product::class)->states('featured')->create([
            '_id' => 'simple-product',
            'name' => 'Simple Product'
        ]);
        $variation = factory(Variation::class)->make([
            '_id' => [$product->_id],
            'real_price' => 10,
            'is_discounted' => false,
            'stock' => 10
        ]);
        $product->variations()->save($variation);

        /** @var Brand $brand */
        $brand = factory(Brand::class)->create();
        $brand->products()->save($product);
        return $product;
    }

    /**
     * @return Product
     */
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

    /**
     * @param int $rate
     */
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

    /**
     * @param int $quantity
     * @return $this
     */
    public function addSimpleProduct(int $quantity = 1)
    {
        $this
            ->postJson('/api/cart', [
                'product_id' => "simple-product",
                'quantity' => $quantity
            ]);

        return $this;
    }

    public function getProductResponse() :array
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

    /**
     * Create discounts
     */
    public function createDiscounts()
    {
        factory(Coupon::class)->create(['name' => 'DISCOUNT10', 'type' => Coupon::PERCENTAGE, 'magnitude' => '-10']);
        factory(Coupon::class)->create(['name' => 'DISCOUNT20', 'type' => Coupon::PERCENTAGE, 'magnitude' => '-20']);
        factory(Coupon::class)->create(['name' => 'DISCOUNT30', 'type' => Coupon::PERCENTAGE, 'magnitude' => '-30']);
    }
}