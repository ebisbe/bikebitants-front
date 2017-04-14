<?php

namespace App;

class Property extends \App\Business\Integration\WooCommerce\Models\Property
{
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['uc_name'];
}
