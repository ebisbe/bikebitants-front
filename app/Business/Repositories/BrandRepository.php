<?php
namespace App\Business\Repositories;

use Rinvex\Repository\Repositories\EloquentRepository;

class BrandRepository extends EloquentRepository
{
    protected $repositoryId = 'rinvex.repository.shop.brand';

    protected $model = 'App\Brand';
}
