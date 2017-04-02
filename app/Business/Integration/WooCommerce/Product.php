<?php

namespace App\Business\Integration\WooCommerce;

use App\Business\Repositories\ProductRepository;
use App\Product as AppProduct;
use Illuminate\Support\Collection;

class Product extends Importer
{
    public $wooCommerceCallback = 'products';
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var Category
     */
    private $category;
    /**
     * @var Review
     */
    private $review;

    /**
     * Product constructor.
     * @param ProductRepository $productRepository
     * @param Category $category
     * @param Review $review
     */
    public function __construct(ProductRepository $productRepository, Category $category, Review $review)
    {

        $this->productRepository = $productRepository;
        $this->category = $category;
        $this->review = $review;
    }

    /**
     * @param $entity
     * @return bool
     */
    public function sync($entity)
    {
        $status = $this->statusSyncro($entity['status'], $entity['catalog_visibility']);
        if ($status == AppProduct::DRAFT) {
            return false;
        }

        $product = $this->appProduct($entity);
        $product->_id = $entity['sku'];
        $product->external_id = $entity['id'];
        $product->name = $entity['name'] ?? $entity['title'];
        $product->status = $status;
        $product->is_featured = $entity['featured'];
        $product->slug = $this->slug($entity);
        $product->description = $this->stripVCRow($entity['description']);
        $product->introduction = $entity['short_description'];
        $product->reviews_allowed = $entity['reviews_allowed'];
        $product->tags = $this->arrayOfTags($entity);
        if (isset($entity['yoast'])) {
            $product->meta_title = $entity['yoast']['title'];
            $product->meta_description = $entity['yoast']['metadesc'];
        }
        //$this->addRelatedProducts($entity, $product);
        $this->addUpSellProducts($entity, $product);
        $this->addCrossSellProducts($entity, $product);

        $this->productRepository->update($product, $product->toArray());


        $properties = new Properties($product);
        $properties->syncProperties($entity['attributes'], $entity['default_attributes'] ?? []);

        $this->category->product($product);
        $this->category->syncCategories($entity['categories']);

        $image = new Image($product);
        $image->syncImages($entity['images']);

        $variation = new Variation($product);
        $variation->syncVariations($entity);
        $this->productRepository->update($product, $product->toArray());

        $this->review->product($product);
        $this->review->wooCommerceCallback("products/{$entity['id']}/reviews");
        $this->review->iterator(',');
        $this->review->pageSeparator('');
        $this->review->import(false);

        return true;
    }

    /**
     * Return status from Product or -1 in case of unknown.
     * @param $status
     * @param $catalog_visibility
     * @return int
     */
    public function statusSyncro($status, $catalog_visibility)
    {
        $statusValues = [
            'draft' => AppProduct::DRAFT,
            'publish' => AppProduct::PUBLISHED,
            'hidden' => AppProduct::HIDDEN
        ];

        if (!isset($statusValues[$status])) {
            return -1;
        }

        return $statusValues[$status] == AppProduct::PUBLISHED
        && in_array($catalog_visibility, ['hidden', 'search'])
            ? AppProduct::HIDDEN
            : $statusValues[$status];
    }

    /**
     * Filter non-desired text from wordpress itself
     * @param $text
     * @return mixed
     */
    public function stripVCRow($text)
    {
        return preg_replace('#\[(/)?vc_.+\]?#', '', $text);
    }

    /**
     * @param $entity
     * @return array
     */
    protected function arrayOfTags($entity): array
    {
        return collect($entity['tags'])->pluck('name')->toArray();
    }

    /**
     * Never use slug again. It doesn't updates correctly
     * @param $entity
     * @return string
     */
    protected function slug($entity): string
    {
        return collect(explode('/', $entity['permalink']))->filter()->last();
    }

    /**
     * @param $entity
     * @return AppProduct
     */
    protected function appProduct($entity): AppProduct
    {
        $product = AppProduct::withTrashed()
            ->orWhere(function ($query) use ($entity) {
                $query->whereExternalId($entity['id'])
                    ->orWhere('_id', $entity['sku']);
            })
            ->first();

        if (!is_null($product) && $product->trashed()) {
            $product->restore();
            return $product;
        }

        return $product ?? new AppProduct();
    }

    /**
     * Adds random items to related. Not now how they do it.
     * @param $entity
     * @param $product
     */
    protected function addRelatedProducts($entity, AppProduct $product)
    {
        $related_product = $this->productsList($entity['related_ids']);
        $product->related()->saveMany($related_product);
    }

    /**
     * @param $entity
     * @param $product
     */
    protected function addUpSellProducts($entity, AppProduct $product)
    {
        $related_product = $this->productsList($entity['upsell_ids']);
        $product->up_sell()->saveMany($related_product);
    }

    /**
     * @param $entity
     * @param $product
     */
    protected function addCrossSellProducts($entity, AppProduct $product)
    {
        $related_product = $this->productsList($entity['cross_sell_ids']);
        $product->cross_sell()->saveMany($related_product);
    }

    /**
     * @param $array
     * @return Collection
     */
    protected function productsList($array)
    {
        return collect($array)->map(function ($id) {
            return AppProduct::whereExternalId($id)->first();
        })->filter();
    }

    public function delete(int $id): bool
    {
        return AppProduct::whereExternalId($id)->delete();
    }
}
