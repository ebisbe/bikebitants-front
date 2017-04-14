<?php

namespace App;

class Billing extends \App\Business\Integration\WooCommerce\Models\Billing
{
    public function states()
    {
        $country = $this->country;
        return $this->country->states->first(function ($state) {
            return $state->_id == $this->state;
        });
    }

    public function country()
    {
        return $this->belongsTo(Country::class, '_id', 'country');
    }
}
