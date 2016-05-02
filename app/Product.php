<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Product extends Model
{

    public function getTagsArray()
    {
        return implode(', ', $this->tags);
    }

    /**
     * Colors defined for the product
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function colors()
    {
        return $this->embedsMany(Color::class);
    }

    /**
     * Sizes defined for the product
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function sizes()
    {
        return $this->embedsMany(Size::class);
    }

    /**
     * Reviews made by the users for the product
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function reviews()
    {
        return $this->embedsMany(Review::class);
    }

    /**
     * Labels attached to the product
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function labels()
    {
        return $this->embedsMany(Label::class);
    }

    /**
     * Images from the product
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function images()
    {
        return $this->embedsMany(Image::class);
    }
}
