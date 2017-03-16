<?php

namespace App\Business\Integration\Wordpress;

use App\Tax as AppTax;

class Tax extends Importer
{
    public $wooCommerceCallback = 'taxes';

    public function sync($entity)
    {
        $tax = AppTax::whereExternalId($entity['id'])->first();
        if (empty($tax)) {
            $tax = new AppTax();
            $tax->external_id = $entity['id'];
        }

        $tax->fill($entity);
        $tax->save();
    }
}
