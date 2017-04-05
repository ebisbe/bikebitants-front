<?php

namespace App\Http\Middleware;

use Cart;
use App\Order;
use Closure;
use Illuminate\Database\Eloquent\Collection;

class CheckoutMiddleware
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
        $flashMessage = 'You cannot checkout the cart without buying.';
        if ($this->shouldRedirect()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response($flashMessage, 401);
            } else {
                $request->session()->flash('flash_message', $flashMessage);
                return redirect(route('shop.catalogue'));
            }
        }

        return $next($request);
    }

    public function terminate($request, $response)
    {
        /** @var Collection $orders */
        $orders = Order::currentOrder()->get();
        if ($orders->isNotEmpty()) {
            /** @var Order $currentOrder */
            $currentOrder = $orders->first();
            if ($currentOrder->status == Order::CONFIRMED) {
                $currentOrder->print_analytics = false;
                $currentOrder->save();
            }
        }
    }

    protected function shouldRedirect()
    {
        //We don't have products and there is no current order started
        if (Cart::isEmpty() && !Order::isCurrentOrderConfirmed()) {
            return true;
        }
        return false;
    }
}
