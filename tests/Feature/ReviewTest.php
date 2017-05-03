<?php

namespace Tests\Feature;

use App\Business\Models\Shop\Product;
use App\Business\Traits\Tests\ProductTrait;
use App\Jobs\ProductReviewRating;
use App\Jobs\PushReview;
use App\Review;
use Hamcrest\Thingy;
use Tests\TestCase;
use Queue;

class ReviewTest extends TestCase
{
    use ProductTrait;

    /** @test
     TODO test error messages
     */
    public function it_adds_a_review()
    {
        $product = $this->createSimpleProduct();

        Queue::fake();

        $response = $this->post(
            route('review.store'),
            [
                'name' => 'Test name',
                'email' => 'test@bikebitants.com',
                'rating' => 5,
                'comment' => 'some test stuff',
                'product_id' => $product->_id
            ],
            [
                'X-Requested-With' => true
            ]
        );

        $response->assertSee('review.success_message');
    }

    /** @test */
    public function it_saves_a_review_and_pushes_two_jobs_to_queue()
    {
        Queue::fake();

        /** @var Product $product */
        $product = factory(Product::class)->create();
        $review = factory(Review::class)->make([
            'external_id' => null,
            'product_id' => $product->_id
        ]);
        $product->reviews()->save($review);

        Queue::assertPushed(PushReview::class, function ($job) use ($product) {
            return $job->review['name'] === $product->fresh()->reviews()->first()->name;
        });

        Queue::assertPushed(ProductReviewRating::class, function ($job) use ($product) {
            return $job->product->_id === $product->_id;
        });
    }

    /** @test */
    public function it_saves_a_review_and_pushes_one_jobs_to_queue()
    {
        Queue::fake();

        /** @var Product $product */
        $product = factory(Product::class)->create();
        $review = factory(Review::class)->make([
            'external_id' => 1234,
            'product_id' => $product->_id
        ]);
        $product->reviews()->save($review);

        Queue::assertNotPushed(PushReview::class);

        Queue::assertPushed(ProductReviewRating::class, function ($job) use ($product) {
            return $job->product->_id === $product->_id;
        });
    }
}
