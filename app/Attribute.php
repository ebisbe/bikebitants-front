<?php

namespace App;

use App\Business\MongoEloquentModel as Model;

class Attribute extends Model
{

    protected $fillable = ['name', 'order'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['uc_name'];

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function attribute_values()
    {
        return $this->embedsMany(AttributeValue::class);
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
