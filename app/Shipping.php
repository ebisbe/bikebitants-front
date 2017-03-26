<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

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
class Shipping extends Model
{
    const CART_CONDITION_TYPE = 'shipping';

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

    public function country()
    {
        return $this->belongsTo(Country::class, '_id', 'country');
    }

    public function states()
    {
        return $this->country->states->first(function ($state) {
            return $state->_id == $this->state;
        });
    }
}
