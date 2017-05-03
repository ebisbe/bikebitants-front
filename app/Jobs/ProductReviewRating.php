<?php

namespace App\Jobs;

use App\Business\Repositories\ProductRepository;
use App\Product;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProductReviewRating extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    public $product;

    /**
     * Create a new job instance.
     *
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Execute the job.
     *
     * @param ProductRepository $productRepository
     * @return void
     */
    public function handle(ProductRepository $productRepository)
    {
        $ratings = $this->product->reviews()
            ->filter(function ($review) {
                return $review->verified;
            });
        $totalRating = $ratings->sum('rating');
        $totalReviews = $ratings->count();

        $rating = $totalReviews > 0 ? $totalRating / $totalReviews : null;

        $productRepository->update($this->product, [
            'rating' => $rating
        ]);
    }
}
