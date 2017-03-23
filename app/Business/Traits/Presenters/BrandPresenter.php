<?php
namespace App\Business\Traits\Presenters;

trait BrandPresenter
{
    /**
     * @return string
     */
    public function getTitleAttribute()
    {
        return ucfirst($this->name) . '. Tienda online | Bikebitants';
    }
}
