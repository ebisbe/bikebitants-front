<?php

namespace App\Business\Integration\WooCommerce;

use App\Product;
use Illuminate\Support\Collection;

class Variation
{
    /**
     * @var Product
     */
    private $product;

    /**
     * Variation constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Import Variations from WooCommerce
     * @param $variations
     */
    public function syncVariations($entity)
    {
        $variations = $this->getVariationsFromEntity($entity);

        $this->product->variations()->each(function ($variation) {
            /** @var \App\Variation $variation */
            $variation->delete();
        });

        $variations
            ->each(function ($wpVariation) {
                $_id = $this->variationsAttributes($wpVariation);

                $variation = new \App\Variation();

                $variation->_id = $_id;
                $variation->sku = $wpVariation['sku'];
                $variation->external_id = $wpVariation['id'];
                $variation->real_price = (float)$wpVariation['regular_price'];
                $variation->discounted_price = (float)$wpVariation['sale_price'];
                $variation->is_discounted = $wpVariation['on_sale'];
                $variation->stock = $this->variationStock($wpVariation);
                $img = $wpVariation[isset($wpVariation['image']) ? 'image' : 'images'][0];
                $variation->filename = Image::saveImage($img);

                $this->product->variations()->save($variation);
            });
    }

    private function variationStock($variation)
    {
        if (!$variation['in_stock']) {
            return 0;
        }
        return is_null($variation['stock_quantity']) ? 25 : $variation['stock_quantity'];
    }

    /**
     * @param $wpVariation
     * @return array
     */
    private function variationsAttributes($wpVariation): array
    {
        $variationsAtt = collect($wpVariation['attributes'])
            ->filter(function ($att) {
                return isset($att['option']);
            })
            ->map(function ($att) {
                return str_slug(strtolower($att['option']));
            })
            ->toArray();
        return array_merge([$this->product->_id], $variationsAtt);
    }

    /**
     * If the product has no variation we treat the product as if it was a variation itself
     * because it has all the params needed
     * @param $entity
     * @return Collection
     */
    protected function getVariationsFromEntity($entity): Collection
    {
        return !empty($entity['variations']) ? collect($entity['variations']) : collect([$entity]);
    }
}
