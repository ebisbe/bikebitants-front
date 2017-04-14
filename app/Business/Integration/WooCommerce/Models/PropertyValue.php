<?php

namespace App\Business\Integration\WooCommerce\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class PropertyValue extends Model
{
    protected $fillable = ['name', 'sku', 'complementary_text', '_id'];
}
