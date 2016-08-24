<?php

namespace App;

use App\Business\MongoEloquentModel as Model;

class Order extends Model
{

    const New = 1;
    const ValidData = 2;
    const ToRedirect = 3;
    const Redirected = 4;
    const Confirmed = 5;
    const Cancelled = -1;
    const Error = -2;

    protected $fillable = [
        'billing_id', 'shipping_id', 'user_id', 'status', 'payment_method'
    ];

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsOne
     */
    public function billing()
    {
        return $this->embedsOne(Billing::class);
    }

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsOne
     */
    public function shipping()
    {
        return $this->embedsOne(Shipping::class);
    }

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function cart()
    {
        return $this->embedsMany(Cart::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return bool
     */
    /*public static function exists()
    {
        return self::whereSessionId(\Request::session()->getId())
            ->where('status', '<>', 5)
            ->count() ? true : false;
    }*/
    /**
     * @return Order|null
     */
    public static function currentOrder() {
        return self::where('_id', \Request::session()->get('order'))->get();
    }
}
