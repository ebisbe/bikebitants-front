<?php

namespace App;

use App\Business\MongoEloquentModel as Model;

class Cart extends Model
{
    //

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
