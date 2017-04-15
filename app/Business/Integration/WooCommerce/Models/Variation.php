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
        'filename'
    ];

    public function sync($entity)
    {
        $entity['_id'] = $this->variationsAttributes($entity['attributes']);
        $entity['real_price'] = (float)$entity['regular_price'];
        $entity['discounted_price'] = (float)$entity['sale_price'];
        $entity['is_discounted'] = $entity['on_sale'];
        $entity['stock'] = $this->variationStock($entity);

        $value = $entity['image'] ?? $entity['images'][0];
        $entity['filename'] = (new Image)->saveImage($value);

        $this->fill($entity);
    }

    private function variationStock($variation)
    {
        if (!$variation['in_stock']) {
            return 0;
        }
        return is_null($variation['stock_quantity']) ? 25 : $variation['stock_quantity'];
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
                return str_slug(strtolower($att['option']));
            })
            ->toArray();
        return array_merge([$this->parent_id], $variationsAtt);
    }
}
