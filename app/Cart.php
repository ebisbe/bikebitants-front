<?php

namespace App;

use App\Business\Models\Shop\Product as ProductShop;
use App\Business\MongoEloquentModel as Model;
use Illuminate\Database\Eloquent\Builder;
use \Request;

class Cart extends Model
{
    /**
     * Each cart has one product
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        //TODO not sure we have to use here ProductShop
        return $this->belongsTo(ProductShop::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Adding global Scopes
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('currentSession', function (Builder $builder) {
            $builder->whereSessionId(Request::session()->getId());
        });
    }

    /**
     * Find a product by it's properties if has some
     * @param $query
     * @param $properties
     * @return mixed
     */
    public function scopeWithProperties($query, $properties)
    {
        return $query->when($properties, function ($query) use ($properties) {
            foreach ($properties as $property => $value) {
                $query->where($property, '=', $value);
            }
            return $query;
        });
    }

    /**
     * Empty cart
     */
    public static function empty()
    {
        self::all()->map(function($item) {
           $item->delete();
        });
    }
}
