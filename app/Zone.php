<?php

namespace App;

use App\Business\MongoEloquentModel as Model;

class Zone extends Model
{
    public function shippingMethods() {
        return $this->embedsMany(ShippingMethod::class);
    }
}
