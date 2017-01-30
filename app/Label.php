<?php

namespace App;

use Moloquent\Eloquent\Model;

class Label extends Model
{
    protected $fillable = ['name', 'css'];
}
