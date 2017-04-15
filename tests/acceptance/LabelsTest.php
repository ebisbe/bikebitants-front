<?php

use App\Business\Traits\Tests\ProductTrait;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LabelsTest extends BrowserKitTest
{
    use ProductTrait;

    /** @test */
    public function see_label_page()
    {
        $this->createSimpleProduct();
        $this->createTax();

        $this->visit('/etiqueta-producto/label1')
            ->seePageIs($this->link('etiqueta-producto/label1'))
            ->seeRouteIs('shop.tag', ['slug' => 'label1']);
    }

    /** @test */
    public function see_404_on_label_page()
    {
        $this->disableExceptionHandling();
        try {
            $this->visit('/etiqueta-producto/label');
        } catch (NotFoundHttpException $e) {
            $this->assertEquals('exceptions.page_not_found', $e->getMessage());
            return;
        }

        $this->fail('Should receive NotFoundHttpException');
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
            ->see('Label1')
            ->click('Label1')
            ->seePageIs($this->link('etiqueta-producto/label1'))
            ->seeRouteIs('shop.tag', ['slug' => 'label1']);
    }
}
