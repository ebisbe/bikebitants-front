<?php

namespace App\Business\Models\Shop;

use App\Business\Traits\HasProductsTrait;
use App\Image;

/**
 * Class Category
 * @package App\Shop
 *
 */
class Category extends \App\Category
{
    use HasProductsTrait;

    public function getFileNameAttribute($value)
    {
        return !empty($value) ? $value : Image::notFound()->filename;
    }
}
