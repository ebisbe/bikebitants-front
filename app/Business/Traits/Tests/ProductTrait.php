<?php

namespace App\Business\Traits\Tests;

use App\Brand;
use App\Business\Models\Shop\Product;
use App\Category;
use App\Coupon;
use App\Tax;
use App\Variation;

trait ProductTrait
{
    /**
     * @return Product
     */
    public function createSimpleProduct( $stock = 10)
    {
        $product = factory(Product::class)->states('featured')->create([
            '_id' => 'simple-product',
            'name' => 'Simple Product',
            'tags' => ['label1', 'label2']
        ]);
        $variation = factory(Variation::class)->make([
            '_id' => [$product->_id],
            'sku' => $product->_id,
            'real_price' => 10,
            'is_discounted' => false,
            'stock' => $stock
        ]);
        $product->variations()->save($variation);

        /** @var Brand $brand */
        $brand = factory(Brand::class)->create(['name' => 'Simple Brand']);
        $brand->products()->save($product);

        /** @var Category $category */
        $category = factory(Category::class)->create(['name' => 'Category 1', 'products_count' => 1]);
        $category->products()->save($product);
        return $product;
    }

    /**
     * @return Product
     */
    public function createProductWithThreeVariations($variation1Stock = 10, $variation2Stock = 10, $variation3Stock = 10)
    {
        /** @var Product $product */
        $product = factory(Product::class)->create([
            '_id' => 'variation-product',
            'name' => 'Variation Product',
            'tags' => ['label2']
        ]);
        $variation1 = factory(Variation::class)->make([
            '_id' => [$product->_id, 'RED'],
            'sku' => $product->_id.'-RED',
            'real_price' => 10,
            'is_discounted' => false,
            'stock' => $variation1Stock
        ]);
        $variation2 = factory(Variation::class)->make([
            '_id' => [$product->_id, 'GREEN'],
            'sku' => $product->_id.'-GREEN',
            'real_price' => 15,
            'is_discounted' => false,
            'stock' => $variation2Stock
        ]);
        $variation3 = factory(Variation::class)->make([
            '_id' => [$product->_id, 'BLUE'],
            'sku' => $product->_id.'-BLUE',
            'real_price' => 20,
            'is_discounted' => false,
            'stock' => $variation3Stock
        ]);
        $product->variations()->saveMany([$variation1, $variation2, $variation3]);

        /** @var Category $category */
        $category = factory(Category::class)->create(['name' => 'Category 2', 'products_count' => 1]);
        $category->products()->save($product);

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
        return $this->addProduct("simple-product", $quantity);
    }

    /**
     * @param int $quantity
     * @param array $properties
     * @return $this
     */
    public function addVariationProduct(int $quantity = 1, array $properties)
    {
        return $this->addProduct("variation-product", $quantity, $properties);
    }

    /**
     * @param string $product_id
     * @param int $quantity
     * @param array $properties
     * @return $this
     */
    public function addProduct(string $product_id, int $quantity = 1, array $properties = [])
    {
        $this
            ->postJson('/api/cart', [
                'product_id' => $product_id,
                'quantity' => $quantity,
                'properties' => $properties
            ]);

        return $this;
    }

    /**
     * @return array
     */
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
