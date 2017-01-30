<?php

namespace App;

use Moloquent\Eloquent\Model;

class ShippingMethod extends Model
{
    protected $fillable = ['name', 'cost', 'price_condition'];
}
