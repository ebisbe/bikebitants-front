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
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var Review
     */
    private $review;

    /**
     * Create a new job instance.
     *
     * @param Review $review
     */
    public function __construct($review)
    {

        $this->review = $review;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //\Woocommerce::post("products/{$this->review->product_id}/reviews", $this->review->toArray());
    }
}
