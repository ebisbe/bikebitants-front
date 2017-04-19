<?php

namespace App\Business\Integration\WooCommerce\Models;

/**
 * Class ShippingMethod
 * @package App\Business\Integration\WooCommerce\Models
 *
 * @attributes string $name
 * @attributes float $cost
 * @attributes float $price_condition
 */
class ShippingMethod extends ApiImporter
{
    protected $fillable = ['name', 'cost', 'price_condition'];

    protected $external_id_name = 'instance_id';

    public function customImport($zone, $external_id = null)
    {
        $this->wooCommerceCallback("shipping/zones/{$external_id}/methods");
        $this->iterator('_');
        $this->pageSeparator('');
        return parent::import(false, $zone, 'shipping_methods');
    }

    public function sync($entity)
    {
        $this->name = $entity['title'];
        if ($entity['method_id'] == 'free_shipping') {
            $this->cost = 0;
            $this->price_condition = $this->float($entity['settings']['min_amount']['value']);
        }

        if ($entity['method_id'] == 'flat_rate') {
            $this->cost = $this->float($entity['settings']['cost']['value']);
            $this->price_condition = 0;
        }
    }

    public function float($value)
    {
        return (float)str_ireplace(',', '.', str_ireplace('.', '', $value));
    }
}
