<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Product extends Model
{

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function colors()
    {
        return $this->embedsMany(Color::class);
    }

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function sizes()
    {
        return $this->embedsMany(Size::class);
    }
}
