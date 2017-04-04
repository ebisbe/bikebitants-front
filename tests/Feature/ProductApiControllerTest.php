<?php

namespace Tests\Feature;

use App\Business\Traits\Tests\ProductTrait;

class ProductApiControllerTest extends \TestCase
{
    use ProductTrait;

    /** @test */
    public function get_product_list()
    {
        $this->disableExceptionHandling();

        $this->createSimpleProduct();
        $this->createProductWithThreeVariations();
        $this->createTax();

        $this->get(route('product.index'))
            ->assertJsonStructure([
                '*' => [
                    'front_image',
                    'front_image_alt',
                    'front_image_hover',
                    'front_image_hover_alt',

                    'route',
                    'name',
                    'introduction',
                    'stock',
                    'rating',
                    'range_price',
                    'lower_price',
                    'currency',
                    'is_featured',
                    'is_discounted',
                    'tags',
                    'has_variations'
                ]
            ]);
    }

    /** @test */
    public function get_full_product()
    {
        $product = $this->createSimpleProduct();
        $this->createTax();

        $this->get(route('product.show', ['product' => $product->_id]))
            ->assertJsonStructure([
                '_id',
                'name',
                'rating',
                'stock'
            ]);
    }
}
