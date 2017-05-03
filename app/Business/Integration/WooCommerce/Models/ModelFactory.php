<?php

namespace App\Business\Integration\WooCommerce\Models;

use App\Business\Integration\WooCommerce\Exception\EntityNotFoundException;

class ModelFactory
{
    /**
     * @param $entity
     * @return Product|Tag|Coupon|Tax|State|AttributeTerms|Order
     * @throws EntityNotFoundException
     */
    public static function make($entity)
    {
        $class = '\\App\\' . ucfirst($entity);

        if (class_exists($class)) {
            return new $class;
        }

        $class = '\\App\\Business\\Integration\\WooCommerce\\Models\\' . ucfirst($entity);

        if (!class_exists($class)) {
            throw new EntityNotFoundException("Entity ". ucfirst($entity). " not found.");
        }

        return new $class;
    }
}