<?php

namespace App\Business\Integration\Wordpress;

use App\Billing;
use App\Shipping;
use App\Customer as AppCustomer;

class Customer extends Importer
{
    public $wooCommerceCallback = 'customers';

    public function sync($entity)
    {
        /** @var \App\Customer $customer */
        $customer = AppCustomer::whereExternalId($entity['id'])->first();
        if (empty($customer)) {
            $customer = new AppCustomer();
            $customer->external_id = $entity['id'];
        }
        $customer->fill($entity);

        $billing = new Billing();
        $billing->fill($entity['billing']);
        $customer->billing()->associate($billing);

        $shipping = new Shipping();
        $shipping->fill($entity['shipping']);
        $customer->shipping()->associate($shipping);

        $customer->save();
    }
}
