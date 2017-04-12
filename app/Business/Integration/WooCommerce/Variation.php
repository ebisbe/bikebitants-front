<?php

namespace App\Business\Integration\WooCommerce;

use App\Business\Repositories\ProductRepository;
use App\Product;
use Carbon\Carbon;

class Variation extends Importer
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /** @var  Product */
    private $product;

    /**
     * Review constructor.
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {

        $this->productRepository = $productRepository;
    }

    public function product(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Import Variations from WooCommerce
     * @param $entity
     */
    public function sync($entity)
    {
        $variation = $this->product
            ->variations()
            ->filter(function ($variation) use ($entity) {
                return $variation->external_id == $entity['id'];
            })
            ->first();
        $new = false;
        if (empty($variation)) {
            $variation = new \App\Review();
            $new = true;
        }

        $_id = $this->variationsAttributes($entity['attributes']);

        $variation = new \App\Variation();

        $variation->_id = $_id;
        $variation->sku = $entity['sku'];
        $variation->external_id = $entity['id'];
        $variation->real_price = (float)$entity['regular_price'];
        $variation->discounted_price = (float)$entity['sale_price'];
        $variation->is_discounted = $entity['on_sale'];
        $variation->stock = $this->variationStock($entity);
        $variation->filename = Image::saveImage($entity['image']);
        $variation->updated_at = Carbon::now();
        $this->product->variations()->save($variation);

        if ($new) {
            $this->product->variations()->save($variation);
            $this->productRepository->update($this->product, $this->product->toArray());
        } else {
            $variation->save();
        }
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
            ->map(function ($att) {
                return str_slug(strtolower($att['option']));
            })
            ->filter()->toArray();
        return array_merge([$this->product->_id], $variationsAtt);
    }

    public function delete(int $id): bool
    {
        // TODO: Implement delete() method.
    }
}
