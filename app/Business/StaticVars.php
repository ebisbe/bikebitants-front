<?php

namespace App\Business;

class StaticVars
{

    /** General Info */
    protected $company = 'Bikebitants';
    protected $email = 'hola@bikebitants.com';
    protected $telephone = '(+34) 696.603.741';
    protected $slogan = 'Tu bici, tu ciudad';

    protected $facebook = 'https://www.facebook.com/bikebitants/';
    protected $twitter = 'https://twitter.com/bikebitants';
    protected $instagram = 'https://www.instagram.com/bikebitants/';
    protected $linkedin = 'https://www.linkedin.com/company/10215920';

    /** Images sizes */
    protected $productDetail = ['360w' => '330', '480w' => '450', '568w' => '538', '1200w' => '355'];
    protected $productRelated = ['360w' => '330', '480w' => '450', '568w' => '254', '600w' => '270', '767w' => '354', '992w' => '213', '1200w' => '263'];
    protected $homeLeft = ['360w' => '150', '480w' => '210', '568w' => '254', '600w' => '270', '767w' => '354', '992w' => '213', '1200w' => '263'];
    protected $homeCategories = ['360w' => '360', '480w' => '480', '568w' => '568', '600w' => '200', '767w' => '256', '992w' => '330', '1200w' => '500'];
    protected $brandMain = ['360w' => '330', '480w' => '450', '568w' => '538', '600w' => '570', '767w' => '600', '993w' => '459', '1200w' => '555'];

    protected $emptyCart = ['fa-shopping-basket', 'fa-shopping-bag', 'fa-shopping-cart'];

    /** Filters for product page */
    protected $filterMinimumValue = 20;
    protected $filterMaximumValue = 300;
    protected $filterSortingType = [/*'popularity', 'average_rating',*/
        'selected' => 'newness', 'low_to_high', 'high_to_low'
    ];
    protected $filterShow = [8 => 8, 12 => 12, 18 => 18, 24 => 24, 'all' => 'all'];
    protected $filterPage = 1;

    protected $imgWrapper = '<div class="item">{img}</div>';

    /**
     * @return string
     */
    public function filterSortingTypeSelected()
    {
        return self::filterSortingType()->first(function ($key, $value) {
            return $key === 'selected';
        });
    }

    /**
     * @return string
     */
    public function filterShowSelected()
    {
        return self::filterShow()->first();
    }

    /**
     * @param string $layoutStyle
     * @return string
     */
    public function layoutHeader($layoutStyle = 'navbar-default navbar-static-top')
    {
        if (empty($layoutStyle)) {
            $layoutStyle = 'navbar-default navbar-static-top';
        }
        return $layoutStyle;
    }

    /**
     * @param string $layoutStyle
     * @return string
     */
    public function layoutTopHeader($layoutStyle = '')
    {
        return $layoutStyle;
    }

    /**
     * @param $name
     * @param $arguments
     * @return \Illuminate\Support\Collection|string
     */
    public function __call($name, $arguments)
    {
        if (is_array($this->$name)) {
            return collect($this->$name);
        }
        return $this->$name;
    }
}