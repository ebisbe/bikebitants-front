<?php

namespace App\Http\Controllers;

use App\Business\Models\Shop\Coupon;
use Darryldecode\Cart\CartCondition;
use Illuminate\Http\Request;
use Cart;
use App\Http\Requests;

class CouponController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'coupon' => 'bail|required|exists:coupons,name|not_expired|minimum_cart|maximum_cart'
        ]);

        $coupon = Coupon::addToCart($request->input('coupon'));

        if (!empty($coupon)) {
            $condition = new CartCondition($coupon);
            $response = Cart::getContent()
                ->map(function ($item) use ($condition) {
                    return Cart::addItemCondition($item->id, $condition);
                });
            // Add condition to cart only to show it on the subtotal. We add them to every item.
            Cart::condition($condition);

            if($response->unique()->first()) {
                $request->session()->push('coupons', $request->input('coupon'));
            }
        }

        return redirect(route('cart.index'));
    }
}
