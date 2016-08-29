<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Buyer extends Model
{

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function billing()
    {
        return $this->embedsMany(Billing::class);
    }

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function shipping()
    {
        return $this->embedsMany(Shipping::class);
    }
}
