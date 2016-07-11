<?php

namespace App;

use App\Business\MongoEloquentModel as Model;

class Category extends Model
{
    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function children() {
        return $this->embedsMany(Category::class);
    }
}
