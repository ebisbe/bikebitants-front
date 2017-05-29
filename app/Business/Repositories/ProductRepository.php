<?php

namespace App\Business\Repositories;

use App\Exceptions\VariationNotFoundException;
use App\Variation;
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


    /**
     * @param string $product_id
     * @param array $properties
     * @return Variation
     * @throws VariationNotFoundException
     */
    public function findVariationByProduct(string $product_id, array $properties):Variation
    {
        $variation = $this->findBy('_id', $product_id)
            ->productVariation(array_merge([$product_id], $properties));

        if (is_null($variation)) {
            throw new VariationNotFoundException(trans('api.variation_not_found'));
        }

        return $variation;
    }
}
