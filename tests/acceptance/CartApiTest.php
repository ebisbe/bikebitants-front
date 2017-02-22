<?php

use App\Business\Traits\Tests\ProductTrait;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class CartApiTest extends BrowserKitTest
{
    use ProductTrait;

    /** @test */
    public function add_one_simple_product_to_cart()
    {
        $this->createTax(21);
        $this->createSimpleProduct();
        $this->addSimpleProduct();
        $this
            ->seeJson([
                '_id' => "simple-product",
                'quantity' => 1,
                'price' => '12.10',
                'is_max_stock' => false
            ])
            ->seeJsonStructure($this->getProductResponse());

        $this->addSimpleProduct(2);
        $this
            ->seeJson([
                'quantity' => 3,
                'is_max_stock' => false
            ]);

        $this->addSimpleProduct(7);
        $this
            ->seeJson([
                'quantity' => 10,
                'is_max_stock' => true
            ]);
    }

    /** @test */
    public function add_more_than_ten_simple_products_to_cart()
    {
        $this->createTax(21);
        $this->createSimpleProduct();

        $this->addSimpleProduct(150);
        $this
            ->seeJson([
                '_id' => "simple-product",
                'quantity' => 10,
                'price' => '12.10',
                'is_max_stock' => true
            ]);
    }

    /** @test */
    public function clear_empty_cart()
    {
        $this->createTax();
        $this
            ->deleteJson('/api/cart/simple-product')
            ->seeJson([
                'success' => false,
                'message' => 'api.cart_empty'
            ])
            ->seeStatusCode(200);
    }

    /** @test */
    public function clear_cart_with_one_simple_product()
    {
        $this->createTax();
        $this->createSimpleProduct();
        //count cart => 0
        $response = $this
            ->getJson('/api/cart')
            ->seeStatusCode(200)
            ->response;
        $this->assertEquals(0, count($response->getOriginalContent()));

        //add simple product
        $this->addSimpleProduct(5);

        //count cart => 1
        $response = $this
            ->getJson('/api/cart')
            ->seeJsonStructure(['*' => $this->getProductResponse()])
            ->seeJson(['quantity' => 5])
            ->response;

        $this->assertEquals(1, count($response->getOriginalContent()));

        $id = $response->getOriginalContent()[0]['_id'];

        //clear product
        $this
            ->deleteJson('/api/cart/' . $id)
            ->seeStatusCode(200)
            ->seeJson([
                'success' => true,
                'message' => 'api.product_deleted'
            ]);
    }

    /** @test */
    public function add_one_product_with_variation()
    {
        //arrange
        $this->createTax();
        $this->createProductWithThreeVariations();

        //act
        $this->addVariationProduct(1, ['RED']);

        //assert
        $response = $this
            ->getJson('/api/cart')
            ->seeJsonStructure(['*' => $this->getProductResponse()])
            ->seeJson(['quantity' => 1])
            ->response;
        $this->assertEquals(1, count($response->getOriginalContent()));

        //act
        $this->addVariationProduct(2, ['RED']);

        //assert
        $this
            ->getJson('/api/cart')
            ->seeJsonStructure(['*' => $this->getProductResponse()])
            ->seeJson(['quantity' => 3]);

        //act
        $this->addVariationProduct(7, ['RED']);

        //assert
        $this
            ->getJson('/api/cart')
            ->seeJsonStructure(['*' => $this->getProductResponse()])
            ->seeJson(['quantity' => 10]);
    }

    /** @test */
    public function add_two_variation_products()
    {
        //arrange
        $this->createTax();
        $this->createProductWithThreeVariations();

        //act
        $this->addVariationProduct(1, ['RED']);
        $this->addVariationProduct(1, ['BLUE']);

        //assert
        $response = $this
            ->getJson('/api/cart')
            ->response;
        $this->assertEquals(2, count($response->getOriginalContent()));
    }

    /** @test */
    public function add_three_variations_to_cart_and_remove_them()
    {
        //arrange
        $this->createTax();
        $this->createProductWithThreeVariations();

        //act
        $this->addVariationProduct(1, ['RED']);
        $this->addVariationProduct(1, ['BLUE']);
        $this->addVariationProduct(1, ['GREEN']);

        $response = $this
            ->getJson('/api/cart')
            ->response;
        $this->assertEquals(3, count($response->getOriginalContent()));

        $id1 = $response->getOriginalContent()[0]['_id'];
        $id2 = $response->getOriginalContent()[1]['_id'];
        $id3 = $response->getOriginalContent()[2]['_id'];

        //act & assert
        $this
            ->deleteJson('/api/cart/' . $id1)
            ->seeStatusCode(200)
            ->seeJson([
                'success' => true,
                'message' => 'api.product_deleted'
            ]);

        //act
        $response = $this
            ->getJson('/api/cart')
            ->response;
        //assert
        $this->assertEquals(2, count($response->getOriginalContent()));

        //act & assert
        $this
            ->deleteJson('/api/cart/' . $id2)
            ->seeStatusCode(200)
            ->seeJson([
                'success' => true,
                'message' => 'api.product_deleted'
            ]);

        //act
        $response = $this
            ->getJson('/api/cart')
            ->response;
        //assert
        $this->assertEquals(1, count($response->getOriginalContent()));

        //act & assert
        $this
            ->deleteJson('/api/cart/' . $id3)
            ->seeStatusCode(200)
            ->seeJson([
                'success' => true,
                'message' => 'api.product_deleted'
            ]);

        //act
        $response = $this
            ->getJson('/api/cart')
            ->response;
        //assert
        $this->assertEquals(0, count($response->getOriginalContent()));
    }

    /** @test */
    public function add_non_existant_variation()
    {
        $this->createTax();
        $this->createProductWithThreeVariations();

        $this->addVariationProduct(1, ['ORANGE'])
            ->seeJson([
                'success' => false,
                'message' => 'api.variation_not_found'
            ]);
    }

    /** @test */
    public function remove_non_existant_variation()
    {
        $this->createTax();
        $this->createProductWithThreeVariations();

        $this->addVariationProduct(1, ['RED']);

        $this
            ->deleteJson('/api/cart/variation-product-ORANGE')
            ->seeStatusCode(200)
            ->seeJson([
                'success' => true,
                'message' => 'api.product_deleted'
            ]);
    }
}
