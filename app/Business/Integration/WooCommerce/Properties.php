<?php

namespace App\Business\Integration\WooCommerce;

use App\Brand;
use App\Product;
use App\Property;
use App\PropertyValue;

class Properties
{
    /**
     * @var Product
     */
    private $product;

    /**
     * Properties constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Import Properties from products if they have. Properties can be from variations or product properties
     * @param $properties
     */
    public function syncProperties($properties, $defaultAttributes)
    {
        $order = 1;
        $ids = [];
        collect($properties)
            ->sortBy('position')
            ->each(function ($attribute) use (&$order, &$ids, $defaultAttributes) {
                if ($attribute['variation']) {
                    $ids[] = $this->syncVariationProperties($attribute, $order, $defaultAttributes);
                    $order++;
                } else {
                    $this->syncAttribute($attribute);
                }
            });

        //Find deleted attributes
        $propertiesToDelete = $this->product
            ->properties()
            ->filter(function ($attribute) use ($ids) {
                return !in_array($attribute['external_id'], $ids);
            });
        //Delete attributes
        $propertiesToDelete->each(function ($attribute) {
            $this->product->properties()->destroy($attribute);
        });
    }

    /**
     * Import variations from product. They are used to handle modifications of the same product
     * @param $variation
     * @param $order
     * @param $defaultAttributes
     * @return String
     */
    public function syncVariationProperties($variation, $order, $defaultAttributes)
    {
        $attribute = $this->product
            ->properties()
            ->filter(function ($attribute) use ($variation) {
                return $attribute->external_id == $variation['id'];
            })
            ->first();
        $new = false;
        if (empty($attribute)) {
            $attribute = new Property();
            $new = true;
        }

        $attribute->name = $variation['name'];
        $attribute->order = $order;
        $attribute->external_id = $variation['id'];

        if ($new) {
            $this->product->properties()->save($attribute);
        } else {
            $attribute->save();
        }

        collect($variation['options'])->each(function ($option) use ($attribute, $defaultAttributes, $variation) {
            $value = new PropertyValue();
            $sku = str_slug(strtolower($option));
            $value->_id = $sku;
            $value->sku = $sku;
            $value->name = $option;
            $value->selected = collect($defaultAttributes)
                    ->where('id', '=', $variation['id'])
                    ->where('option', '=', $sku)->count() == 1;
            $value->complementary_text = '';
            $attribute->properties_values()->save($value);
        });

        $attribute->save();
        return $variation['id'];
    }

    /**
     * Import Attribute for a product
     * @param $attribute
     */
    public function syncAttribute($attribute)
    {
        if ($attribute['name'] == 'brand') {
            $brand = Brand::whereName($attribute['options'][0])->first();
            if (empty($brand)) {
                $brand = new Brand();
            }
            $brand->name = $attribute['options'][0];
            $brand->save();
            $brand->products()->save($this->product);
        } else {
            $this->product->{$attribute['name']} = $attribute['options'][0];
        }
    }
}
