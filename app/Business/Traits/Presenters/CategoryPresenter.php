<?php
namespace App\Business\Traits\Presenters;

use App\Image;

trait CategoryPresenter
{
    /**
     * @return string
     */
    public function getTitleAttribute()
    {
        $title = ucfirst($this->name);
        if (!empty($this->father->name)) {
            $title .= '. ' . $this->father->name;
        }

        return $title . '. Tienda online | Bikebitants';
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getFileNameAttribute($value)
    {
        return !empty($value) ? $value : Image::notFound()->filename;
    }
}
