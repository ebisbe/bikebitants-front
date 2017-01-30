<?php

namespace App;

use Moloquent\Eloquent\Model;

class Shipping extends Model
{
    const CART_CONDITION_TYPE = 'shipping';

    protected $fillable = [
        'first_name', 'last_name', 'email', 'address_1', 'address_2', 'city', 'postcode', 'phone', 'country', 'state', 'fax', 'phone'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, '_id', 'country');
    }

    public function states()
    {
        return $this->country->states->first(function ($state) {
            return $state->_id == $this->state;
        });
    }
}
