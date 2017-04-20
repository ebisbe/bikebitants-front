<?php

namespace App\Business\Integration\WooCommerce;

use App\Business\Integration\WooCommerce\Models\ModelFactory;
use App\Business\Integration\WooCommerce\Models\Product;
use App\Business\Integration\WooCommerce\Models\Property;

// TODO review this class to follow ApiImporter Pattern
class Properties
{
    /**
     * @var Product
     */
    private $product;

    /** @var Int $order Order for variation properties */
    private $order;

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
     * @param $defaultAttributes
     */
    public function syncProperties($properties, $defaultAttributes)
    {
        $this->product->properties()->each(function ($property) {
            /** @var \App\Property $property */
            $property->delete();
        });

        $this->order = 1;
        collect($properties)
            ->sortBy('position')
            ->each(function ($attribute) use ($defaultAttributes) {
                if ($attribute['variation']) {
                    $this->syncVariationProperties($attribute, $defaultAttributes);
                } else {
                    $this->syncAttribute($attribute);
                }
            });
    }

    /**
     * Import variations from product. They are used to handle modifications of the same product
     * @param $variation
     * @param $order
     * @param $defaultAttributes
     * @return String
     */
    public function syncVariationProperties($variation, $defaultAttributes)
    {
        /** @var Property $property */
        $property = ModelFactory::make('Property');

        $property->name = $variation['name'];
        $property->order = $this->order++;
        $property->external_id = $variation['id'];

        $this->product->properties()->save($property);

        $this->propertyValues($variation, $defaultAttributes, $property);
        return $variation['id'];
    }

    /**
     * Import Attribute for a product
     * @param $attribute
     */
    public function syncAttribute($attribute)
    {
        if ($attribute['name'] == 'brand') {
            $brandModel = ModelFactory::make('brand');
            $brand = $brandModel->firstOrNew(['name' => $attribute['options'][0]]);
            $brand->name = $attribute['options'][0];
            $brand->save();
            $brand->products()->save($this->product);
        } else {
            $this->product->{$attribute['name']} = $attribute['options'][0];
        }
    }

    /**
     * @param $variation
     * @param $defaultAttributes
     * @param $property
     */
    protected function propertyValues($variation, $defaultAttributes, $property)
    {
        collect($variation['options'])->each(function ($option) use ($property, $defaultAttributes, $variation) {
            $value = ModelFactory::make('PropertyValue');

            $sku = ModelFactory::make('AttributeTerms')->getSkuFromOption($option);
            // TODO review if duplication can be avoided
            $value->_id = $sku;
            $value->sku = $sku;
            $value->name = $option;
            $value->selected = collect($defaultAttributes)
                    ->where('id', '=', $variation['id'])
                    ->where('option', '=', $sku)->count() == 1;
            $value->complementary_text = '';
            $property->properties_values()->save($value);
        });

        $property->save();
    }
}
