<?php
namespace App\Business\Repositories;

use Rinvex\Repository\Repositories\EloquentRepository;

class TaxRepository extends EloquentRepository
{
    protected $repositoryId = 'rinvex.repository.shop.tax';

    protected $model = \App\Business\Models\Shop\Tax::class;
}
