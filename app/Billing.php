<?php

namespace App;

use App\Business\MongoEloquentModel as Model;

class Billing extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'email', 'address', 'address_2', 'city', 'postcode', 'phone', 'country', 'province', 'phone'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, '_id', 'country');
    }

    public function provinces()
    {
        return $this->country->provinces->first(function($province) {
            return $province->_id == $this->province;
        });
    }
}
