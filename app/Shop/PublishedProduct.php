<?php

namespace App\Shop;

use App\Business\Traits\PublishedProductsTrait;
use App\Product;

class PublishedProduct extends Product
{
    use PublishedProductsTrait;
}
