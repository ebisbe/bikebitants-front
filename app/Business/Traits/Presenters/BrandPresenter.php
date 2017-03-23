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

    public function getMetaDescriptionAttribute()
    {
        return 'Compra todos los accesorios ' . ucfirst($this->name) . ' al mejor precio en nuestra tienda online. Envío gratuito y devolución fácil.';
    }
}
