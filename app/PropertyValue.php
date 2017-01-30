<?php

namespace App;

use Moloquent\Eloquent\Model;

class PropertyValue extends Model
{
    protected $fillable = ['name', 'sku', 'complementary_text', '_id'];
}
