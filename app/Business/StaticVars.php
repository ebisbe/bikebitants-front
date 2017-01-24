<?php

namespace App\Business;

class StaticVars
{

    /** General Info */
    protected $company = 'Bikebitants';
    protected $email = 'hola@bikebitants.com';
    protected $telephone = '(+34) 930.044.543';
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
    protected $filterMinimumValue = 1;
    protected $filterMaximumValue = 500;
    protected $filterSortingType = [/*'popularity', 'average_rating',*/
        'selected' => 'newness', 'low_to_high', 'high_to_low', 'featured', 'discounted'
    ];
    protected $filterShow = [8 => 8, 12 => 12, 18 => 18, 24 => 24, 'all' => 'all'];
    protected $filterPage = 1;

    protected $imgWrapper = '<div class="item">{img}</div>';

    public $emailValidation = '/^([\w+-.%]+@[\w-.]+\.[A-Za-z]{2,4}(, )?)+$/';

    public $wordpressDateTime = 'Y-m-d\TH:i:s';

    public $logo = 'data:image/png;base64,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';

    /**
     * @return string
     */
    public function filterSortingTypeSelected()
    {
        return self::filterSortingType()->first(function ($value, $key) {
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
