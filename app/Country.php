<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Jenssegers\Mongodb\Eloquent\Model;

class Country extends Model
{

    protected $casts = ['active' => 'boolean'];

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function provinces()
    {
        return $this->embedsMany(Province::class);
    }

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();
        
        static::addGlobalScope('active', function(Builder $builder) {
            $builder->where('active', '=', 1);
        });
    }
}
