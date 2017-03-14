<?php

use App\Business\Traits\Tests\ProductTrait;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\BrowserKitTesting\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SimpleProductTest extends BrowserKitTest
{
    use ProductTrait;

    /** @test */
    public function find_simple_product_at_home()
    {
        $this->createTax();
        $this->createSimpleProduct();

        $this->visit('/')
            ->see('Simple Product')
            ->click('Simple Product')
            ->see('Simple Product')
            ->seePageIs($this->link('simple-product'))
            ->seeRouteIs('shop.slug', ['slug' => 'simple-product']);
    }

    /** @test */
    public function get_404_from_unknown_product()
    {
        try {
            $this->visit('/wp-content');
        } catch (HttpException $e) {
            $this->assertEquals($e->getPrevious()->getMessage(), 'exceptions.page_not_found');
            return;
        }

        $this->fail('Should receive exception.');
    }

    /** @test */
    public function get_404_from_unknown_subcategory()
    {
        try {
            $this->visit('/wp-content/common.php.suspected');
        } catch (HttpException $e) {
            $this->assertEquals($e->getPrevious()->getMessage(), 'exceptions.page_not_found');
            return;
        }

        $this->fail('Should receive exception.');
    }
}
