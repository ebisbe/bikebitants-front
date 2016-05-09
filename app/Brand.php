<?php

namespace App;

use App\Business\MongoEloquentModel as Model;

class Brand extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function services()
    {
        return $this->embedsMany(BrandService::class);
    }
}
