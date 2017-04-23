<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Builder;

class Zone extends \App\Business\Integration\WooCommerce\Models\Zone
{
    public $wooCommerceCallback = 'shipping/zones';

    /**
     * @param Builder $query
     * @param string $state
     * @return $this
     */
    public function scopeInState(Builder $query, $state)
    {
        return $query->whereIn('state', (array)$state);
    }
}
