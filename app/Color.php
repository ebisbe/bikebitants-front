<?php

namespace App;

use App\Business\MongoEloquentModel as Model;

class Color extends Model
{
    protected $dates = [
        'updated_at',
        'created_at'
    ];
}
