<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Jenssegers\Mongodb\Eloquent\Builder;
use Jenssegers\Mongodb\Eloquent\Model;

class Zone extends Model
{
    protected $fillable = ['name', 'state'];

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany|Collection
     */
    public function shipping_methods()
    {
        return $this->embedsMany(ShippingMethod::class);
    }

    /**
     * @param Builder $query
     * @param string $state
     * @return $this
     */
    public function scopeInState(Builder $query, $state)
    {
        return $query->whereIn('state', (array)$state);
    }
}
