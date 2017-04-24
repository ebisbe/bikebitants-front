<?php

namespace Tests\Acceptance;

use App\Business\Integration\WooCommerce\Exception\EntityNotFoundException;
use App\Business\Integration\WooCommerce\Exception\InvalidEventException;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class WebHookTest extends TestCase
{
    use WithoutMiddleware;

    /** @test */
    public function webhook_receives_entity_not_found()
    {
        $this->disableExceptionHandling();

        $response = $this->post(route('woo.webhook'), [], [
            'x-wc-webhook-resource' => 'BlaBla'
        ]);
        $response
            ->assertStatus(404)
            ->assertJson(['error' => 'Entity BlaBla not found.']);
    }

    /** @test */
    public function webhook_receives_invalid_event_found()
    {
        $this->disableExceptionHandling();

        $response = $this->post(route('woo.webhook'), [], [
            'x-wc-webhook-resource' => 'product',
            'x-wc-webhook-event' => 'BlaBla'
        ]);

        $response
            ->assertStatus(404)
            ->assertJson(['error' => 'Invalid event given \'BlaBla\'.']);
    }

    /** @test */
    public function webhook_receives_new_tag()
    {
        $this->disableExceptionHandling();

        $response = $this->post(
            route('woo.webhook'),
            [
                'id' => 123,
                'name' => 'BlaBla'
            ],
            [
                'x-wc-webhook-resource' => 'tag',
                'x-wc-webhook-event' => 'created'
            ]
        );

        $response
            ->assertStatus(200)
            ->assertJson(['created' => true]);
    }
}
