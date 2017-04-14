<?php

namespace App\Business\Integration\WooCommerce\Models;

/**
 * Class Tag
 * @package App\Business\Integration\WooCommerce\Models
 *
 */
class Tag extends ApiImporter
{
    public $wooCommerceCallback = 'products/tags';

    protected $fillable = ['id', 'external_id', 'name', 'slug', 'description', 'count'];

    protected $casts = [
        'count' => 'real',
    ];
}
