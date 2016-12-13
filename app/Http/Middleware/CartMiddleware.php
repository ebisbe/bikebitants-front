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
        $taxCol = TaxService::getTax();
        if (!$taxCol->isEmpty()) {
            $tax = $taxCol->first();
            Cart::condition(new CartCondition([
                'name' => $tax->name,
                'type' => 'tax',
                'target' => 'subtotal',
                'value' => $tax->rate . '%',
                'order' => 5
            ]));
        }

        $order = $this->order->currentOrder()->get();
        if ($order->isEmpty()
            || $order->first()->status >= Order::Redirected
            || $order->first()->status < Order::New
        ) {
            $request->session()->forget('order');
        }

        return $next($request);
    }
}
