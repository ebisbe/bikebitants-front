<?php

namespace App;

use App\Business\MongoEloquentModel as Model;

class Review extends Model
{

    /**
     * Comments on a comment
     *
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function children()
    {
        return $this->embedsMany(Review::create());
    }
}
