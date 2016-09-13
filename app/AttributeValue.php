<?php

namespace App;

use App\Business\MongoEloquentModel as Model;

class AttributeValue extends Model
{
    protected $fillable = ['name', 'sku', 'complementary_text', '_id'];
}
