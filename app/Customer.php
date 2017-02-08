<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Customer extends Model
{

    protected $fillable = ['email', 'first_name', 'last_name', 'username', 'last_order', 'orders_count', 'total_spent', 'avatar_url'];

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
