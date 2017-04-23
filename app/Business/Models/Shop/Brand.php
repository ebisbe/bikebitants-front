<?php

namespace App\Business\Models\Shop;

use App\Business\Traits\Presenters\BrandPresenter;

/**
 * Class Brand
 * @package App\Shop
 *
 */
class Brand extends \App\Business\Integration\WooCommerce\Models\Brand
{
    use BrandPresenter;
}
