<?php
namespace App\Business\Repositories;

use App\Business\Models\Shop\Brand;
use Rinvex\Repository\Repositories\EloquentRepository;

class BrandRepository extends EloquentRepository
{
    protected $repositoryId = 'rinvex.repository.shop.brand';

    protected $model = Brand::class;
}
