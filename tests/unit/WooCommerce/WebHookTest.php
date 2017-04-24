<?php

namespace Tests\Unit\WooCoomerce;

use App\Business\Integration\WooCommerce\Exception\InvalidPayloadException;
use App\Business\Integration\WooCommerce\WebHook;
use Tests\TestCase;

class WebHookTest extends TestCase
{
    /** @test */
    public function verify_valid_payload_request()
    {
        $webHook = new WebHook();

        $payload = json_encode(array());
        $signature = 'OXcEXcxAhQOzCtBiHFA2PVUR3BDGCuD9popZTMyUrr8=';

        $response = $webHook->verifyPayload($payload, $signature);

        $this->assertTrue($response);
    }

    /** @test */
    public function verify_invalid_payload_request()
    {
        $webHook = new WebHook();

        $payload = json_encode(array());
        $signature = 'Invalid signature=';

        try {
            $webHook->verifyPayload($payload, $signature);
        } catch (InvalidPayloadException $e) {
            $this->assertEquals('Invalid payload.', $e->getMessage());
            return ;
        }

        $this->fail('Should receive InvalidPayloadException');
    }
}
