<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Variation extends Model
{
    protected $fillable = ['_id', 'price'];
}
