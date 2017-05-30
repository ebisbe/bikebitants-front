<?php

namespace App\Business\Integration\WooCommerce\Models;

//TODO review because it's not like api
class Variation extends ApiImporter
{
    protected $fillable = [
        '_id',
        'external_id',
        'sku',
        'real_price',
        'discounted_price',
        'is_discounted',
        'stock',
        'in_stock',
        'filename'
    ];

    public function customImport($product, $external_id)
    {
        $this->wooCommerceCallback("products/{$external_id}/variations");
        $this->iterator('_');
        $this->pageSeparator('');
        return parent::import(true, $product, 'variations');
    }

    public function sync($entity)
    {
        $entity['_id'] = $this->variationsAttributes($entity['attributes']);
        $entity['real_price'] = (float)$entity['regular_price'];
        $entity['discounted_price'] = (float)$entity['sale_price'];
        $entity['is_discounted'] = $entity['on_sale'];
        $entity['stock'] = $entity['in_stock'] ? $entity['stock_quantity'] : 0;

        $value = $entity['image'] ?? $entity['images'][0];
        $entity['filename'] = (new Image)->saveImage($value);

        $this->fill($entity);
    }

    /**
     * @param $attributes
     * @return array
     */
    private function variationsAttributes($attributes): array
    {
        $variationsAtt = collect($attributes)
            ->filter(function ($att) {
                // Needed for products without variations
                return isset($att['option']);
            })
            ->map(function ($att) {
                return ModelFactory::make('AttributeTerms')->getSkuFromOption($att['option']);
            })
            ->toArray();


        return array_merge([$this->parent_id], $variationsAtt);
    }
}
