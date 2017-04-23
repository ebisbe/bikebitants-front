<?php

namespace App;

class Billing extends \App\Business\Integration\WooCommerce\Models\Billing
{
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
