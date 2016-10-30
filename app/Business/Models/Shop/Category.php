<?php

namespace App\Business\Models\Shop;

use App\Business\Traits\HasProductsTrait;

/**
 * Class Category
 * @package App\Shop
 *
 */
class Category extends \App\Category
{
    use HasProductsTrait;
}
