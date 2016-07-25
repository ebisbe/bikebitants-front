<?php

namespace App\Http\Controllers;

use App\Coupon;
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

        $coupon = Coupon::whereName($request->input('coupon'))->first();

        $condition = new CartCondition(array(
            'name' => $coupon->name,
            'type' => $coupon->type,
            'target' => $coupon->target,
            'value' => $coupon->value,
        ));
        Cart::condition($condition);

        return redirect(route('cart.index'));
    }
}
