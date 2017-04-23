<?php

namespace App\Http\Middleware;

use App\Order;
use Cart;
use Closure;
use TaxService;
use Darryldecode\Cart\CartCondition;

/**
 * Class CartMiddleware
 * @package App\Http\Middleware
 */
class CartMiddleware
{
    protected $order;

    /**
     * CartMiddleware constructor.
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $tax = TaxService::getTax();
        Cart::condition(new CartCondition([
            'name' => 'IVA',
            'type' => 'tax',
            'target' => 'item',
            'value' => $tax->rate . '%',
            'order' => 5
        ]));

        $order = $this->order->currentOrder()->get();
        if ($order->isEmpty()
            || $order->first()->status >= Order::REDIRECTED
            || $order->first()->status < Order::NEW
        ) {
            $request->session()->forget('order');
        }

        return $next($request);
    }
}
