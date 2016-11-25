<?php

namespace App\Business\Models\Shop;

use App\Business\Traits\LastCouponTrait;

class Coupon extends \App\Coupon
{
    use LastCouponTrait;
}