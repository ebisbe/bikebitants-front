<?php

namespace Tests\Feature;

use App\Jobs\PushReview;
use App\Product;
use App\Review;
use Tests\TestCase;

class PushReviewTest extends TestCase
{

    /** @test */
    public function it_pushes_a_review_to_woocommerce_api()
    {
        $product = factory(Product::class)->create([
            'external_id' => 1234
        ]);
        $review = factory(Review::class)->make([
            'rating' => 5,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'comment' => 'Blabla'
        ]);
        $pushReview = new PushReview($review, $product->external_id);

        \Woocommerce::shouldReceive('post')
            ->once()
            ->with(
                "products/1234/reviews",
                [
                    'review' => 'Blabla',
                    'rating' => 5,
                    'name' => 'John Doe',
                    'email' => 'john@example.com',
                ]
            );

        $pushReview->handle();
    }
}
