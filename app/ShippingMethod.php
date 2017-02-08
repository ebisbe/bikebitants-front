<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class ShippingMethod extends Model
{
    protected $fillable = ['name', 'cost', 'price_condition'];
}
