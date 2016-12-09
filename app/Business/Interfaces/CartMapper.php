<?php

namespace App\Business\Interfaces;

use Darryldecode\Cart\ItemCollection;

interface CartMapper {

    public function mapItem(ItemCollection $itemCollection);
}