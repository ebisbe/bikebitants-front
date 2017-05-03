<?php

namespace App\Jobs;

use App\Review;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PushReview implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;
    /**
     * @var array
     */
    public $review;
    /**
     * @var
     */
    public $product_id;

    /**
     * Create a new job instance.
     *
     * @param Review $review
     * @param $product_id
     */
    public function __construct(Review $review, $product_id)
    {
        $this->review = $review->pushArray();
        $this->product_id = $product_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Woocommerce::post(
            "products/{$this->product_id}/reviews",
            $this->review
        );
    }
}
