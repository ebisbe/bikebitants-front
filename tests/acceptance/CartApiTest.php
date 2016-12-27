<?php

use App\Business\Traits\Tests\ProductTrait;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class CartApiTest extends TestCase
{
    use ProductTrait, DatabaseMigrations;

    /**
     * @test
     */
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

    /**
     * @test
     */
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

    /**
     * @test
     */
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

    /**
     * @test
     */
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


        //clear product
        $this
            ->deleteJson('/api/cart/simple-products')
            ->seeStatusCode(200)
            ->seeJson([
                'success' => true,
                'message' => 'api.product_deleted'
            ]);
    }
}