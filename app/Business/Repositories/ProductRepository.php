<?php
namespace App\Business\Repositories;

use Rinvex\Repository\Repositories\EloquentRepository;

class ProductRepository extends EloquentRepository
{
    protected $repositoryId = 'rinvex.repository.published_product';

    protected $model = 'App\Shop\PublishedProduct';
}