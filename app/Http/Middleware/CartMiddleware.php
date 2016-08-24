<?php

namespace App\Http\Middleware;

use Cart;
use Closure;

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
        $condition = new \Darryldecode\Cart\CartCondition([
            'name' => 'VAT 12.5%',
            'type' => 'tax',
            'target' => 'subtotal',
            'value' => '12.5%',
        ]);
        Cart::condition($condition);

        return $next($request);
    }
}
