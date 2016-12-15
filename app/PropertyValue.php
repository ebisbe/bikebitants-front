<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class PropertyValue extends Model
{
    protected $fillable = ['name', 'sku', 'complementary_text', '_id'];
}
