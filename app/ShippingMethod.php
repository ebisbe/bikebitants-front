<?php

namespace App;

class ShippingMethod extends \App\Business\Integration\WooCommerce\Models\ShippingMethod
{
    protected $fillable = ['name', 'cost', 'price_condition'];
}
