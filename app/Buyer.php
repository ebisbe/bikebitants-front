<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Buyer extends Model
{

    protected $fillable = ['first_name', 'email'];

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function billing()
    {
        return $this->embedsOne(Billing::class);
    }

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function shipping()
    {
        return $this->embedsOne(Shipping::class);
    }
}
