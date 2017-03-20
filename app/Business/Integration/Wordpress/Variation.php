<?php

namespace App\Business\Integration\Wordpress;

use App\Product;

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
        $variations = !empty($entity['variations']) ? $entity['variations'] : [$entity];

        collect($variations)
            ->each(function ($wpVariation) {
                $variation = $this->product
                    ->variations()
                    ->filter(function ($variation) use ($wpVariation) {
                        return $variation->external_id == $wpVariation['id'];
                    })->first();

                $_id = $this->variationsAttributes($wpVariation);

                $new = false;
                if (empty($variation)) {
                    $variation = new \App\Variation();
                    $new = true;
                } elseif ($_id != $variation->_id) {
                    $variation->delete();
                    $new = true;
                }

                $variation->_id = $_id;
                $variation->sku = $wpVariation['sku'];
                $variation->external_id = $wpVariation['id'];
                $variation->real_price = (float)$wpVariation['regular_price'];
                $variation->discounted_price = (float)$wpVariation['sale_price'];
                $variation->is_discounted = $wpVariation['on_sale'];
                $variation->stock = $this->variationStock($wpVariation);
                $img = $wpVariation[isset($wpVariation['image']) ? 'image' : 'images'][0];
                $variation->filename = Image::saveImage($img);

                if ($new) {
                    $this->product->variations()->save($variation);
                } else {
                    $variation->save();
                }
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
}
