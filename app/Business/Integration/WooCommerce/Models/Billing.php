<?php

namespace App\Business\Integration\WooCommerce\Models;

/**
 * Class Billing
 * @package App
 *
 * @property string first_name
 * @property string last_name
 * @property string email
 * @property string address_1
 * @property string address_2
 * @property string city
 * @property string state
 * @property string postcode
 * @property string phone
 * @property Country country
 * @property string company
 * @property string company_cif
 * @property string cif
 */
class Billing extends ApiImporter
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
        'company',
        'cif'
    ];

    public function getCompanyCifAttribute()
    {
        if (!empty($this->company) && !empty($this->cif)) {
            return $this->company . ' (' . $this->cif . ')';
        } else {
            return $this->company . $this->cif;
        }
    }

}
