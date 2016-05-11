<?php

namespace App;

use App\Business\MongoEloquentModel as Model;

class Attribute extends Model
{
    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function attribute_values()
    {
        return $this->embedsMany(AttributeValue::class);
    }
}
