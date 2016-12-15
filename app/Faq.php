<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = ['name', 'answer'];
}
