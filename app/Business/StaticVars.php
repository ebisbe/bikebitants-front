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

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->$name;
    }

    /** Images sizes */
    protected $product_detail = ['360w' => '330', '480w' => '450', '568w' => '538', '1200w' => '355'];
    protected $product_related = ['360w' => '330', '480w' => '450', '568w' => '254', '600w' => '270', '767w' => '354', '292w' => '213', '1200w' => '263'];

    /**
     * Product detail page, detail image
     * @return \Illuminate\Support\Collection
     */
    public function productDetail()
    {
        return collect($this->product_detail);
    }

    /**
     * Product detail page, related products image
     * @return \Illuminate\Support\Collection
     */
    public function productRelated()
    {
        return collect($this->product_related);
    }
}