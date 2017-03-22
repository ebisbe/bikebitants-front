<?php

namespace App\Business\Integration\WooCommerce;

use App\Business\Integration\WooCommerce\Exception\EntityNotFoundException;

class Factory
{
    /**
     * @param $entity
     * @return Product|Customer|Coupon|Category|Tax
     * @throws EntityNotFoundException
     */
    public static function make($entity)
    {
        $class = '\\App\\Business\\Integration\\WooCommerce\\' . ucfirst($entity);

        if (!class_exists($class)) {
            throw new EntityNotFoundException("Entity ". ucfirst($entity). " not found.");
        }

        return \App::make($class);
    }
}