<?php

namespace App;

use App\Business\MongoEloquentModel as Model;

class Faq extends Model
{
    protected $fillable = ['name', 'answer'];
}
