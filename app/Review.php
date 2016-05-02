<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

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
