<?php

namespace App\Jobs;

use App\Business\Repositories\ProductRepository;
use App\Category;
use App\Jobs\Job;
use App\Product;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateCategories extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /** @var  Product $product */
    protected $product;

    /**
     * UpdateCategories constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * @param ProductRepository $productRepository
     * @return bool
     */
    public function handle(ProductRepository $productRepository)
    {
        $categories = [];
        /** @var Category $category */
        $category = $this->product->category()->first();

        if (is_null($category)) {
            return false;
        }

        if (!empty($category->father->slug)) {
            $categories[] = $category->father->slug;
        }

        $categories[] = $category->slug;
        $this->product->categories = $categories;

        $productRepository->update($this->product, $this->product->toArray());

        return true;
    }
}
