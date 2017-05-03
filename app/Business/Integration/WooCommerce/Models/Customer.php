<?php

namespace App\Business\Integration\WooCommerce\Models;

class Customer extends ApiImporter
{
    public $wooCommerceCallback = 'customers';

    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'username',
        'last_order',
        'orders_count',
        'total_spent',
        'avatar_url',
        'external_id'
    ];

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsOne
     */
    public function billing()
    {
        return $this->embedsOne(Billing::class);
    }

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsOne
     */
    public function shipping()
    {
        return $this->embedsOne(Shipping::class);
    }

    public function sync($entity)
    {
        $this->fill($entity);

        $billing = new Billing();
        $billing->fill($entity['billing']);
        $this->billing()->associate($billing);

        $shipping = new Shipping();
        $shipping->fill($entity['shipping']);
        $this->shipping()->associate($shipping);
    }
}
