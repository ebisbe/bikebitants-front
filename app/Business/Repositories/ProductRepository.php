<?php
namespace App\Business\Repositories;

use Rinvex\Repository\Repositories\EloquentRepository;
use App\Business\Models\Shop\Product;

/**
 * Class ProductRepository
 * @package App\Business\Repositories
 *
 * @method Product find($product_id, $attributes = [])
 */
class ProductRepository extends EloquentRepository
{
    protected $repositoryId = 'rinvex.repository.shop.product';

    protected $model = \App\Business\Models\Shop\Product::class;
}
