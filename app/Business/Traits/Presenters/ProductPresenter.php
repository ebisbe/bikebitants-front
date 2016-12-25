<?php
namespace App\Business\Traits\Presenters;

use App\Image;
use \TaxService;

trait ProductPresenter
{

    /**
     * Get a single point to find a price. The product can be a variable or simple
     * @return string
     */
    public function getRangePriceAttribute()
    {
        return $this->setRangePriceLabel('price');

    }

    /**
     * Get a single point to find a price. The product can be a variable or simple
     * @return string
     */
    public function getRangeRealPriceAttribute()
    {
        return $this->setRangePriceLabel('real_price');
    }

    /**
     * @param $price
     * @return string
     */
    private function setRangePriceLabel($price)
    {
        $min = TaxService::applyTax($this->variations->min($price));
        $max = TaxService::applyTax($this->variations->max($price));
        if ($min != $max) {
            return $min . $this->currency . ' - ' . $max . $this->currency;
        }
        return $min . $this->currency;
    }

    public function getStatusTextAttribute()
    {
        return trans('Product.' . $this->status);
    }

    /**
     * While we have just one currency we set a default value.
     * @return string
     */
    public function getCurrencyAttribute()
    {
        return '&euro;';
    }

    /**
     * Convert tags array into a comma list.
     * @return string
     */
    public function getTagsListAttribute()
    {
        return is_array($this->tags) ? implode(', ', $this->tags) : $this->tags;
    }

    public function setIsFeaturedAttribute($featured)
    {
        $this->attributes['is_featured'] = (bool)$featured;
    }

    public function setIsDiscountedAttribute($is_discounted)
    {
        $this->attributes['is_discounted'] = (bool)$is_discounted;
    }

    /**
     * Returns front image but creates empty image if no images found
     * @return Image
     */
    public function getFrontImageAttribute()
    {
        return $this->images()->first() ?? Image::notFound();
    }

    /**
     * Returns front image hover but creates emtpy image if no images found
     * @return Image
     */
    public function getFrontImageHoverAttribute()
    {
        $hover = $this->images()->slice(1, 1)->first();
        if (is_null($hover)) {
            return $this->front_image;
        }
        return $hover;
    }

    /**
     * @return string
     */
    public function getStockLabelAttribute()
    {
        $add = '';
        if ($this->hasLowStock()) {
            $add = " ( $this->stock )";
        }

        return $this->stock != 0 ? trans('catalogue.in_stock') . $add : trans('catalogue.out_of_stock');
    }
}