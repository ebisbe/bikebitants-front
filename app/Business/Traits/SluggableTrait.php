<?php

namespace App\Business\Traits;

trait SluggableTrait
{
    public static function bootSluggableTrait()
    {
        static::saving(function ($element) {
            if (!isset($element->slug)) {
                $element->slug = str_slug($element->name);
            }
        });
    }
}