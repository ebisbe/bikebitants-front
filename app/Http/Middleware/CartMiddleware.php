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

        //Cart::condition($condition);

        return $next($request);
    }
}
