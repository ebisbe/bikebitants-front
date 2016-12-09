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
            'coupon' => 'bail|required|exists:coupons,name|not_expired|minimum_cart|maximum_cart'
        ]);

        $response = $couponService->addCoupon($request);
        if (
            $response->count() == 1
            && $response->first()
        ) {
            $request->session()->push('coupons', $request->input('coupon'));
        }
        return redirect()->back();
    }
}
