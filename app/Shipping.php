<?php

namespace App;

/**
 * @property mixed full_name
 * @property mixed address
 */
class Shipping extends \App\Business\Integration\WooCommerce\Models\Shipping
{
    const CART_CONDITION_TYPE = 'shipping';

    protected $appends = ['full_name', 'address'];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getAddressAttribute()
    {
        return $this->address_1 . ' ' . $this->address_2;
    }

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
