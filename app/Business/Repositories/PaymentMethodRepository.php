<?php
namespace App\Business\Repositories;

use App\PaymentMethod;
use Rinvex\Repository\Repositories\EloquentRepository;

class PaymentMethodRepository extends EloquentRepository
{
    protected $repositoryId = 'rinvex.repository.shop.shipment_method';

    protected $model = PaymentMethod::class;
}
