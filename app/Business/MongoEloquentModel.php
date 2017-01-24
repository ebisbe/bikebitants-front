<?php

namespace App\Business;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

abstract class MongoEloquentModel extends Eloquent implements \Serializable
{
    protected $connection = 'mongodb';
    protected $array_fields = [];

    /**
     * @return string
     */
    public function serialize()
    {
        $model = SerializeUtil::serialize($this->attributes);
        $relations = SerializeUtil::serialize($this->relations);
        return serialize(['model' => $model, 'relations' => $relations]);
    }

    public function unserialize($serialized)
    {
        $data = SerializeUtil::unserialize($serialized);
        foreach ($data['model'] as $key => $value) {
            $this->setAttribute($key, $value);
        }
        $this->setRelations($data['relations']);
        $this->exists = isset($this->attributes['_id']) && !empty($this->attributes['_id']);
    }
}
