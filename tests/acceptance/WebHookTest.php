<?php

use App\Business\Integration\WooCommerce\Exception\EntityNotFoundException;
use App\Business\Integration\WooCommerce\Exception\InvalidEventException;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class WebHookTest extends BrowserKitTest
{
    use WithoutMiddleware;

    /** @test */
    public function webhook_receives_entity_not_found()
    {
        $this->disableExceptionHandling();

        $this->post('api/woo/webhook', [], [
            'x-wc-webhook-resource' => 'BlaBla'
        ])
            ->seeJson(['error' => 'Entity BlaBla not found.']);
    }

    /** @test */
    public function webhook_receives_invalid_event_found()
    {
        $this->disableExceptionHandling();

        $this->post('api/woo/webhook', [], [
            'x-wc-webhook-resource' => 'product',
            'x-wc-webhook-event' => 'BlaBla'
        ])
            ->seeJson(['error' => 'Invalid event given \'BlaBla\'.']);
    }

    /** @test */
    public function webhook_receives_new_tag()
    {
        $this->disableExceptionHandling();

        $this->post(
            'api/woo/webhook',
            [
                'id' => 123,
                'name' => 'BlaBla'
            ],
            [
                'x-wc-webhook-resource' => 'tag',
                'x-wc-webhook-event' => 'created'
            ]
        )->seeJson(['created' => true]);
    }

}
