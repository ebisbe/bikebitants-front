<?php

namespace App\Business\Models\Shop;

use App\Business\Traits\HasProductsTrait;
use App\Business\Traits\Presenters\CategoryPresenter;

/**
 * Class Category
 * @package App\Shop
 *
 */
class Category extends \App\Category
{
    use HasProductsTrait, CategoryPresenter;
}
