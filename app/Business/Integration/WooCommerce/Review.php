<?php

namespace App\Business\Integration\WooCommerce;

use App\Business\Repositories\ProductRepository;
use App\Product;

class Review extends Importer
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

    public function sync($entity)
    {
        $review = $this->product
            ->reviews()
            ->filter(function ($review) use ($entity) {
                return $review->external_id == $entity['id'];
            })
            ->first();
        $new = false;
        if (empty($review)) {
            $review = new \App\Review();
            $new = true;
        }

        $review->external_id = $entity['id'];
        $review->product_id = $this->product->_id;
        $review->name = $entity['name'];
        $review->email = $entity['email'];
        $review->comment = $entity['review'];
        $review->verified = $entity['verified'];
        $review->rating = $entity['rating'];
        $review->created_at = $this->convertDate($entity['date_created']);

        if ($new) {
            $this->product->reviews()->save($review);
            $this->productRepository->update($this->product, $this->product->toArray());
        } else {
            $review->save();
        }
    }

    public function delete(int $id): bool
    {
        // TODO: Implement delete() method.
    }
}
