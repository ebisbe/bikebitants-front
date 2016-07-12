<?php

namespace App;

use App\Business\MongoEloquentModel as Model;

class Category extends Model
{
    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function children()
    {
        return $this->embedsMany(Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * @param string $slugSubCategory
     * @return mixed
     */
    public function whereSlugSubCategory($slugSubCategory = '')
    {
        return $this->children()
            ->filter(function ($value, $key) use ($slugSubCategory) {
                return empty($slugSubCategory) || $value->slug == $slugSubCategory;
            });
    }
}
