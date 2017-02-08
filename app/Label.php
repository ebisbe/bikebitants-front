<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Label extends Model
{
    protected $fillable = ['name', 'css'];
}
