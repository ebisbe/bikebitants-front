<?php

namespace App\Http\Controllers;

use App\Business\Services\CouponService;
use Illuminate\Http\Request;
use App\Http\Requests;

class CouponController extends Controller
{
    public function store(Request $request, CouponService $couponService)
    {
        $this->validate($request, [
            'coupon' => 'bail|required|coupon_exists|not_expired|minimum_cart|maximum_cart'
        ]);

        $couponService->addCoupon($request->input('coupon'));

        return redirect()->back();
    }
}
