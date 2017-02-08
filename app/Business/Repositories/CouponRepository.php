<?php
namespace App\Business\Repositories;

use Rinvex\Repository\Repositories\EloquentRepository;

class CouponRepository extends EloquentRepository
{
    protected $repositoryId = 'rinvex.repository.shop.coupon';

    protected $model = \App\Business\Models\Shop\Coupon::class;
}
