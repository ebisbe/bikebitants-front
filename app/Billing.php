<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

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
 * @property string postcode
 * @property string phone
 * @property string country
 * @property string state
 */
class Billing extends Model
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
