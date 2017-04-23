<?php

namespace App\Business\Integration\WooCommerce\Models;

use Illuminate\Support\Collection;

class State extends ApiImporter
{
    public function customImport($external_id = null): Collection
    {
        $locations = collect(\Woocommerce::get("shipping/zones/{$external_id}/locations"));
        return $locations->pluck('code')->map(function ($code) {
            return collect(explode(':', $code))->last();
        });
    }
}
