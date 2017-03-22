<?php

namespace App\Business\Integration\WooCommerce;

use App\Business\Repositories\ProductRepository;
use App\Product as AppProduct;

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

        $product = AppProduct::orWhere(function ($query) use ($entity) {
            $query->whereExternalId($entity['id'])
                ->orWhere('_id', $entity['sku']);
        })
            ->first();

        if (empty($product)) {
            $product = new AppProduct();
        }

        $product->_id = $entity['sku'];
        $product->external_id = $entity['id'];
        $product->name = $entity['name'];
        $product->status = $status;
        $product->is_featured = $entity['featured'];
        /** Never use slug again. It doesn't updates correctly */
        $product->slug = collect(explode('/', $entity['permalink']))->filter()->last();
        $product->description = $this->stripVCRow($entity['description']);
        $product->introduction = $entity['short_description'];
        $product->reviews_allowed = $entity['reviews_allowed'];
        $product->tags = collect($entity['tags'])
            ->map(function ($tag) {
                return $tag['name'];
            })->toArray();
        $this->productRepository->update($product, $product->toArray());

        $properties = new Properties($product);
        $properties->syncProperties($entity['attributes'], $entity['default_attributes']);

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
}
