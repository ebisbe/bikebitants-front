<?php

use App\Business\Traits\Tests\ProductTrait;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LabelsTest extends BrowserKitTest
{
    use ProductTrait;

    /** @test */
    public function see_label_page()
    {
        $this->visit('/etiqueta-producto/label')
            ->seePageIs($this->link('etiqueta-producto/label'))
            ->seeRouteIs('shop.tag', ['slug' => 'label'])
        ;
    }

    /** @test */
    public function see_desired_label()
    {
        $this->createTax();
        $this->createSimpleProduct();

        $this->visit('/etiqueta-producto/label1')
            ->see('Simple Product')
            ->dontSee('Variation product');
    }

    /** @test */
    public function see_label_in_product_page()
    {
        $this->createTax();
        $this->createSimpleProduct();

        $this->visit('/simple-product')
            ->see('label1')
            ->click('label1')
            ->seePageIs($this->link('etiqueta-producto/label1'))
            ->seeRouteIs('shop.tag', ['slug' => 'label1'])
            ;
    }
}
