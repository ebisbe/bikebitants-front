<?php

namespace App\Business\Integration\WooCommerce;

interface SynchronizeEntity
{
    public function sync($entity);

    public function delete(int $id): bool;
}