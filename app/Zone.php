<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Zone extends Model
{
    public function shippingMethods() {
        return $this->embedsMany(ShippingMethod::class);
    }
}
