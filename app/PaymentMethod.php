<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = ['description'];

    const CASH_ON_DELIVERY = 'cash-on-delivery';
    const REDSYS = 'redsys';
    const PAYPAL = 'paypal';
    const BANK_TRANSFER = 'bank-transfer';
}
