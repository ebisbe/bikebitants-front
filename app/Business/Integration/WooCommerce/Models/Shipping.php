<?php

namespace App\Business\Integration\WooCommerce\Models;

/**
 * Class Shipping
 * @package App
 *
 * @property string first_name
 * @property string last_name
 * @property string email
 * @property string address_1
 * @property string address_2
 * @property string city
 * @property string postcode
 * @property string phone
 * @property Country country
 * @property string state
 */
class Shipping extends ApiImporter
{

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'address_1',
        'address_2',
        'city',
        'postcode',
        'phone',
        'country',
        'state',
        'fax',
    ];

}

