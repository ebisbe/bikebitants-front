<?php

namespace App\Http\Middleware;

use App\Cart;
use Closure;

class CheckoutMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $flashMessage = 'You cannot checkout the cart without buying.';
        if (Cart::all()->isEmpty()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response($flashMessage, 401);
            } else {
                $request->session()->flash('flash_message', $flashMessage);
                return redirect(route('shop.catalogue'));
            }
        }

        return $next($request);
    }
}
