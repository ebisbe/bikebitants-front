<?php

namespace App\Http\Middleware;

use App\Order;
use Cart;
use Closure;
use Darryldecode\Cart\CartCondition;

class CartMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Cart::condition(new CartCondition([
            'name' => 'IVA',
            'type' => 'tax',
            'target' => 'subtotal',
            'value' => '21%',
            'order' => 5
        ]));

        $order = Order::currentOrder();
        if ($order->isEmpty()
            || $order->first()->status >= Order::Redirected
            || $order->first()->status < Order::New
        ) {
            $request->session()->forget('order');
        }

        return $next($request);
    }
}
