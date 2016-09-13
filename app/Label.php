<?php

namespace App;

use App\Business\MongoEloquentModel as Model;

class Label extends Model
{
    protected $fillable = ['name', 'css'];
}
