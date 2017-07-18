<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @property string name
 */
class PaymentMethod extends Model
{
    protected $fillable = ['name', 'description', 'order', 'short_description'];

    const CASH_ON_DELIVERY = 'cash-on-delivery';
    const REDSYS = 'redsys';
    const PAYPAL = 'paypal';
    const BANK_TRANSFER = 'bank-transfer';
    const PAGA_MAS_TARDE = 'paga-mas-tarde';
}
