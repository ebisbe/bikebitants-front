<?php

namespace App;

use App\Business\MongoEloquentModel as Model;

class Billing extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'email', 'address', 'city', 'postal_code', 'phone', 'country', 'province', 'phone'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
