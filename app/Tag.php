<?php
namespace App;

use App\Business\Traits\SluggableTrait;

class Tag extends \App\Business\Integration\WooCommerce\Models\Tag
{
    use SluggableTrait;
}
