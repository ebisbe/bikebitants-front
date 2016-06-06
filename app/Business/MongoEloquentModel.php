<?php

namespace App\Business;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

abstract class MongoEloquentModel extends Eloquent implements \Serializable
{
    protected $connection = 'mongodb';
    protected $array_fields = [];

    public function serialize()
    {
        return SerializeUtil::serialize($this->attributes);
    }

    public function unserialize($serialized)
    {
        $data = SerializeUtil::unserialize($serialized);
        foreach($data as $key => $value) {
            $this->setAttribute($key, $value);
        }
        $this->exists = isset($this->attributes['_id']) && !empty($this->attributes['_id']);
    }
}