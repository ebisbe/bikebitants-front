<?php

use App\Business\Traits\Tests\ProductTrait;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CatalogueTest extends BrowserKitTest
{
    use ProductTrait, DatabaseMigrations;

    /** @test */
    public function see_two_products_at_shop()
    {
        $this->createTax();
        $this->createSimpleProduct();
        $this->createProductWithThreeVariations();

        $this->visit(route('shop.catalogue'));

        $this->see('Simple Product')
            ->see('Variation Product');
    }

    /** @test */
    public function see_each_product_at_each_category()
    {
        $this->createTax();
        $this->createSimpleProduct();
        $this->createProductWithThreeVariations();

        $this->visit(route('shop.slug', ['slug' => 'category-1']));
        $this->see('Simple Product')
            ->dontSee('Variation Product');

        $this->visit(route('shop.slug', ['slug' => 'category-2']));
        $this->see('Variation Product')
            ->dontSee('Simple Product');
    }
}
