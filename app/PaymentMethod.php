<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = ['description'];
}
