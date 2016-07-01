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
    protected $productRelated = ['360w' => '330', '480w' => '450', '568w' => '254', '600w' => '270', '767w' => '354', '292w' => '213', '1200w' => '263'];

    protected $emptyCart = ['fa-shopping-basket', 'fa-shopping-bag', 'fa-shopping-cart'];

    /**
     * @param $name
     * @param $arguments
     * @return \Illuminate\Support\Collection|string
     */
    public function __call($name, $arguments)
    {
        if(is_array($this->$name)) {
            return collect($this->$name);
        }
        return $this->$name;
    }
}