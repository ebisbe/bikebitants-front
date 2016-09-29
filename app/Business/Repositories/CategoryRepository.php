<?php
namespace App\Business\Repositories;

use Rinvex\Repository\Repositories\EloquentRepository;

class CategoryRepository extends EloquentRepository
{
    protected $repositoryId = 'rinvex.repository.shop.category';

    protected $model = 'App\Category';
}