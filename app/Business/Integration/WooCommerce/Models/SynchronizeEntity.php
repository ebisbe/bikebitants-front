<?php

namespace App\Business\Integration\WooCommerce\Models;

interface SynchronizeEntity
{
    public function sync($entity);
}