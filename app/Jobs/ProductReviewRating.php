<?php

namespace App\Jobs;

use App\Business\Repositories\ProductRepository;
use App\Jobs\Job;
use App\Product;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProductReviewRating extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $product;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Execute the job.
     *
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

        if ($totalReviews > 0) {
            $productRepository->update($this->product, [
                'rating' => $totalRating / $totalReviews
            ]);
        }
    }
}
