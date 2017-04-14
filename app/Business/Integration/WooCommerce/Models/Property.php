<?php

namespace App\Business\Integration\WooCommerce\Models;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * Class Property
 * @package App
 *
 * @property string $name
 * @property int $order
 * @property string $external_id
 */
class Property extends Model
{

    protected $fillable = ['name', 'order', 'external_id'];

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function properties_values()
    {
        return $this->embedsMany(PropertyValue::class);
    }

    /**
     * Convert Name attribute into UcFirst()
     * @return string
     */
    public function getUcNameAttribute()
    {
        return ucfirst($this->attributes['name']);
    }
}
