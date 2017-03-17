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
        return $this->getRangePriceLabel('price');
    }

    /**
     * Get a single point to find a price. The product can be a variable or simple
     * @return string
     */
    public function getRangeRealPriceAttribute()
    {
        return $this->getRangePriceLabel('real_price');
    }

    /**
     * @param $price
     * @return string
     */
    private function getRangePriceLabel($price)
    {
        $min = $this->lowerPrice($price);
        $max = $this->variations->max($price);

        if (is_null($min) || is_null($max)) {
            return '-';
        }

        $minTax = TaxService::applyTax($min);
        $maxTax = TaxService::applyTax($max);
        if ($min != $max) {
            return $minTax . $this->html_currency . ' - ' . $maxTax . $this->html_currency;
        }
        return $minTax . $this->html_currency;
    }

    private function lowerPrice($price)
    {
        return $this->variations->where('price', '>', 0)->min($price);
    }

    public function getLowerPriceAttribute()
    {
        $lowest_price = $this->lowerPrice('price');

        if (is_null($lowest_price)) {
            return '-';
        }

        return TaxService::applyTax($lowest_price);
    }

    /**
     * While we have just one currency we set a default value.
     * @return string
     */
    public function getHtmlCurrencyAttribute()
    {
        return '&euro;';
    }

    /**
     * While we have just one currency we set a default value.
     * @return string
     */
    public function getCurrencyAttribute()
    {
        return 'EUR';
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
        return $this->images()->first() && $this->images()->first()->filename != ''
            ? $this->images()->first()
            : Image::notFound();
    }

    /**
     * Returns front image hover but creates emtpy image if no images found
     * @return Image
     */
    public function getFrontImageHoverAttribute()
    {
        $hover = $this->images()->slice(1, 1)->first();
        if (is_null($hover) || empty($hover->filename)) {
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

    public function getTitleAttribute()
    {
        $title = isset($this->meta_title) && !is_null($this->meta_title) ? $this->meta_title : $this->name;

        return $title . ' | ' . config('app.name');
    }

    public function getMetaDescAttribute()
    {
        return isset($this->meta_description) && !is_null($this->meta_description)
            ? $this->meta_description
            : $this->introduction;
    }

    /**
     * @param string $view_name
     * @param null $position
     * @return array
     * @internal param $iteration
     */
    public function gaProduct($view_name = '', $position = null)
    {
        return collect([
            'id' => $this->_id,
            'name' => $this->name,
            'brand' => isset($this->brand->name) ? $this->brand->name : '',
            'category' => isset($this->category->name) ? $this->category->name : '',
            'list' => $view_name,
            'position' => $position
        ])->filter()->toJson();
    }
}
