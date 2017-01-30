<?php

namespace App;

use Moloquent\Eloquent\Model;

class Tax extends Model
{
    protected $fillable = ['country', 'state', 'postcode', 'city', 'rate', 'name', 'order', 'external_id'];

    protected $casts = ['rate' => 'float'];
}
