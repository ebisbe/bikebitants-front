<?php
namespace App\Business\Traits\Presenters;

use App\Business\Services\TaxService;

trait ProductPresenter
{

    /**
     * Get a single point to find a price. The product can be a variable or simple
     * @return string
     */
    public function getRangePriceAttribute()
    {
        $min = $this->variations->min('price');
        $max = $this->variations->max('price');
        if ($min != $max) {
            return TaxService::applyTax($min) . $this->currency . ' - ' . TaxService::applyTax($max) . $this->currency;
        }
        return TaxService::applyTax($min) . $this->currency;
    }

    /**
     * Get a single point to find a price. The product can be a variable or simple
     * @return string
     */
    public function getRangeRealPriceAttribute()
    {
        $min = $this->variations->min('real_price');
        $max = $this->variations->max('real_price');
        if ($min != $max) {
            return TaxService::applyTax($min) . $this->currency . ' - ' . TaxService::applyTax($max) . $this->currency;
        }
        return TaxService::applyTax($min) . $this->currency;
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
     * @return Image|null
     */
    public function getFrontImageAttribute()
    {
        return $this->images()->first();
    }

    /**
     * @return Image|null
     */
    public function getFrontImageHoverAttribute()
    {
        $hover = $this->images()->slice(1, 1)->first();
        if (is_null($hover)) {
            return $this->getFrontImageAttribute();
        }
        return $hover;
    }


    public function getStockLabelAttribute()
    {
        $add = '';
        if($this->stock <= 10) {
            $add = " ( $this->stock )";
        }

        return $this->stock != 0 ? trans('catalogue.in_stock').$add : trans('catalogue.out_of_stock');
    }
}