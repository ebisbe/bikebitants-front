<?php

namespace App\Business\Integration\Wordpress;

interface SynchronizeEntity
{
    public function sync($entity);
}