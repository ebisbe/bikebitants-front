<?php

namespace App\Business;

class StaticVars
{

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