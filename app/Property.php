<?php

namespace App;

use Moloquent\Eloquent\Model;

class Property extends Model
{

    protected $fillable = ['name', 'order', 'external_id'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['uc_name'];

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
