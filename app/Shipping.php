<?php

namespace App;

class Shipping extends \App\Business\Integration\WooCommerce\Models\Shipping
{
    const CART_CONDITION_TYPE = 'shipping';

    public function states()
    {
        return $this->countryName()->states->first(function ($state) {
            return $state->_id == $this->state;
        });
    }

    public function countryName()
    {
        return Country::where('_id', '=', $this->country)->first();
    }
}
