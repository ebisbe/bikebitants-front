<?php

namespace App\Business\Integration\WooCommerce\Models;

use Illuminate\Database\Eloquent\Collection;

class Zone extends ApiImporter
{
    protected $fillable = ['name', 'state', 'external_id'];

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany|Collection
     */
    public function shipping_methods()
    {
        return $this->embedsMany(ShippingMethod::class);
    }

    public function import($paginate = true, $parent = null, $child = null)
    {
        return parent::import(false, $parent, $child);
    }

    public function sync($entity)
    {
        if ($entity['external_id'] == 0) {
            // we ignore Rest of the world
            return false;
        }

        $state = ModelFactory::make('state');
        $states = $state->customImport($entity['external_id']);
        $entity['state'] = $states->toArray();
        $this->fill($entity);
    }

    public function afterSync($entity)
    {
        $this->shipping_methods->each->delete();
        /** @var ShippingMethod $shippingMethod */
        $shippingMethod = ModelFactory::make('ShippingMethod');
        $shippingMethod->customImport($this, $entity['external_id']);
    }
}
