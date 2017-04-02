<?php

namespace App\Business\Integration\WooCommerce;

use App\Business\Integration\WooCommerce\Exception\InvalidPayloadException;

class WebHook
{

    /**
     * @param string $payload
     * @param string $signature
     * @return bool
     * @throws InvalidPayloadException
     */
    public function verifyPayload(string $payload, string $signature): bool
    {
        $calculated_hmac = base64_encode(
            hash_hmac(
                'sha256',
                $payload,
                config('woocommerce.webhook_secret'),
                true
            )
        );

        if ($signature != $calculated_hmac) {
            throw new InvalidPayloadException('Invalid payload.');
        }

        return true;
    }
}