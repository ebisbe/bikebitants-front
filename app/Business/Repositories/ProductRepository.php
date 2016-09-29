<?php
namespace App\Business\Repositories;

use Rinvex\Repository\Repositories\EloquentRepository;

class ProductRepository extends EloquentRepository
{
    protected $repositoryId = 'rinvex.repository.shop.product';

    protected $model = 'App\Business\Models\Shop\Product';
}