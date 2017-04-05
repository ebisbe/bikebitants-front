<?php

namespace App\Business\Services;

use App\Order;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class OrderService
{
    public function cancelByInactivity(): Collection
    {
        $breakPoint = Carbon::now()->addSeconds(config('app.order_expire_time'));
        return Order::where('created_at', '<', $breakPoint)
            ->where('status', '>', Order::CANCELLED)
            ->where('status', '<', Order::CONFIRMED)
            ->get();
    }

    public function notPushedToWordPress(): Collection
    {
        return Order::where('status', '=', Order::CONFIRMED)
            ->where(function ($query) {
                $query->whereNull('external_id')
                    ->orWhere('external_id', 'exists', false)
                    ->orWhere('external_id', '=', '');
            })
            ->get();
    }
}
