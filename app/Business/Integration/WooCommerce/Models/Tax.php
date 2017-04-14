<?php

namespace App\Business\Integration\WooCommerce\Models;

/**
 * Class Tax
 * @package App\Business\Integration\WooCommerce\Models
 *
 */
class Tax extends ApiImporter
{
    public $wooCommerceCallback = 'taxes';

    protected $fillable = [
        'country',
        'state',
        'postcode',
        'city',
        'rate',
        'name',
        'priority',
        'compound',
        'shipping',
        'order',
        'class',
        'external_id'
    ];

    protected $casts = [
        'rate' => 'float',
        'priority' => 'real',
        'order' => 'real',
    ];

}
