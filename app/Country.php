<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Builder;

class Country extends \App\Business\Integration\WooCommerce\Models\Country
{
    protected $fillable = ['states'];

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('active', '=', 1);
        });
    }
}
