<?php

namespace App;

use App\Business\MongoEloquentModel as Model;

class Billing extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'email', 'address_1', 'address_2', 'city', 'postcode', 'phone', 'country', 'state', 'phone'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, '_id', 'country');
    }

    public function states()
    {
        return $this->country->states->first(function($state) {
            return $state->_id == $this->state;
        });
    }
}
