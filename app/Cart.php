<?php

namespace App;

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
        return $this->belongsTo(Product::class);
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
     * Find a product by it's attributes if has some
     * @param $query
     * @param $attributes
     * @return mixed
     */
    public function scopeWithAttributes($query, $attributes)
    {
        return $query->when($attributes, function ($query) use ($attributes) {
            foreach ($attributes as $attribute => $value) {
                $query->where($attribute, '=', $value);
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
