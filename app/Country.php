<?php

namespace App;

use App\Business\Scopes\ActiveScope;
use Jenssegers\Mongodb\Eloquent\Model;

class Country extends Model
{
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
        
        static::addGlobalScope(new ActiveScope());
    }
}
