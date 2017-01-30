<?php

namespace App;

use Moloquent\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = ['name', 'answer'];
}
