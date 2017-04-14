<?php

namespace App;

class Shipping extends \App\Business\Integration\WooCommerce\Models\Shipping
{
    const CART_CONDITION_TYPE = 'shipping';

    public function states()
    {
        return $this->country->states->first(function ($state) {
            return $state->_id == $this->state;
        });
    }

    public function country()
    {
        return $this->belongsTo(Country::class, '_id', 'country');
    }
}
