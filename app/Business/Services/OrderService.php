<?php

namespace App\Business\Services;

use App\Order;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class OrderService
{
    public function cancelByInactivity() : Collection
    {
        $breakPoint = Carbon::now()->addSeconds(config('app.order_expire_time'));
        return Order::where('created_at', '<', $breakPoint)
            ->where('status', '>', Order::Cancelled)
            ->where('status', '<', Order::Confirmed)
            ->get();
    }
}