<?php

namespace App\Business\Models\Shop;

use App\Business\Traits\LastCouponTrait;
use App\Cart;

class Coupon extends \App\Coupon
{
    use LastCouponTrait;
}
