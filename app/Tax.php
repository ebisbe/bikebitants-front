<?php

namespace App;

use App\Business\MongoEloquentModel as Model;

class Tax extends Model
{
    protected $fillable = ['country', 'state', 'postcode', 'city', 'rate', 'name', 'order', 'external_id'];
}
