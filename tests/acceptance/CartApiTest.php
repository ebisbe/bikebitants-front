<?php

namespace Tests\Acceptance;

use App\Business\Traits\Tests\ProductTrait;
use App\Exceptions\VariationNotFoundException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class CartApiTest extends TestCase
{
    use ProductTrait;

    /** @test */
    public function it_adds_one_simple_product_to_cart()
    {
        $this->createTax(21);
        $this->createSimpleProduct();
        $response = $this->addSimpleProduct();
        $response
            ->assertStatus(200)
            ->assertJson([
                '_id' => "simple-product",
                'quantity' => 1,
                'price' => '12.10',
                'is_max_stock' => false
            ])
            ->assertJsonStructure($this->getProductResponse());

        $response = $this->addSimpleProduct(2);
        $response
            ->assertStatus(200)
            ->assertJson([
                'quantity' => 3,
                'is_max_stock' => false
            ]);

        $response = $this->addSimpleProduct(7);
        $response
            ->assertStatus(200)
            ->assertJson([
                'quantity' => 10,
                'is_max_stock' => true
            ]);
    }

    /** @test */
    public function it_adds_more_than_ten_simple_products_to_cart()
    {
        $this->createTax(21);
        $this->createSimpleProduct();

        $response = $this->addSimpleProduct(150);
        $response
            ->assertStatus(200)
            ->assertJson([
                '_id' => "simple-product",
                'quantity' => 10,
                'price' => '12.10',
                'is_max_stock' => true
            ]);
    }

    /** @test */
    public function it_clears_already_empty_cart()
    {
        $this->createTax();
        $response = $this
            ->deleteJson('/api/cart/simple-product');
        $response
            ->assertJson([
                'success' => false,
                'message' => 'api.cart_empty'
            ])
            ->assertStatus(200);
    }

    /** @test */
    public function it_clears_cart_with_one_simple_product()
    {
        $this->createTax();
        $this->createSimpleProduct();
        //count cart => 0
        $response = $this
            ->getJson('/api/cart');

        $response->assertStatus(200);
        $this->assertEquals(0, count($response->getOriginalContent()));

        //add simple product
        $this->addSimpleProduct(5);

        //count cart => 1
        $response = $this
            ->getJson('/api/cart');
        $response
            ->assertStatus(200)
            ->assertJsonStructure(['*' => $this->getProductResponse()])
            ->assertJson([['quantity' => 5]]);

        $this->assertEquals(1, count($response->getOriginalContent()));

        $id = $response->getOriginalContent()[0]['_id'];

        //clear product
        $response = $this
            ->deleteJson('/api/cart/' . $id);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'api.product_deleted'
            ]);
    }

    /** @test */
    public function it_adds_one_product_with_variation()
    {
        //arrange
        $this->createTax();
        $this->createProductWithThreeVariations();

        //act
        $this->addVariationProduct(1, ['RED']);

        //assert
        $response = $this
            ->getJson('/api/cart');
        $response
            ->assertStatus(200)
            ->assertJsonStructure(['*' => $this->getProductResponse()])
            ->assertJson([['quantity' => 1]]);
        $this->assertEquals(1, count($response->getOriginalContent()));

        //act
        $this->addVariationProduct(2, ['RED']);

        //assert
        $response = $this
            ->getJson('/api/cart');
        $response
            ->assertStatus(200)
            ->assertJsonStructure(['*' => $this->getProductResponse()])
            ->assertJson([['quantity' => 3]]);

        //act
        $this->addVariationProduct(7, ['RED']);

        //assert
        $response = $this
            ->getJson('/api/cart');
        $response
            ->assertStatus(200)
            ->assertJsonStructure(['*' => $this->getProductResponse()])
            ->assertJson([['quantity' => 10]]);
    }

    /** @test */
    public function it_adds_two_variation_products_to_cart()
    {
        //arrange
        $this->createTax();
        $this->createProductWithThreeVariations();

        //act
        $this->addVariationProduct(1, ['RED']);
        $this->addVariationProduct(1, ['BLUE']);

        //assert
        $response = $this
            ->getJson('/api/cart');
        $this->assertEquals(2, count($response->getOriginalContent()));
    }

    /** @test */
    public function it_adds_three_variations_to_cart_and_remove_them()
    {
        //arrange
        $this->createTax();
        $this->createProductWithThreeVariations();

        //act
        $this->addVariationProduct(1, ['RED']);
        $this->addVariationProduct(1, ['BLUE']);
        $this->addVariationProduct(1, ['GREEN']);

        $response = $this
            ->getJson('/api/cart');

        $this->assertEquals(3, count($response->getOriginalContent()));

        $id1 = $response->getOriginalContent()[0]['_id'];
        $id2 = $response->getOriginalContent()[1]['_id'];
        $id3 = $response->getOriginalContent()[2]['_id'];

        //act & assert
        $response = $this
            ->deleteJson('/api/cart/' . $id1);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'api.product_deleted'
            ]);

        //act
        $response = $this
            ->getJson('/api/cart');

        //assert
        $this->assertEquals(2, count($response->getOriginalContent()));

        //act & assert
        $response = $this
            ->deleteJson('/api/cart/' . $id2);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'api.product_deleted'
            ]);

        //act
        $response = $this
            ->getJson('/api/cart');

        //assert
        $this->assertEquals(1, count($response->getOriginalContent()));

        //act & assert
        $response = $this
            ->deleteJson('/api/cart/' . $id3);
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'api.product_deleted'
            ]);

        //act
        $response = $this
            ->getJson('/api/cart');
        //assert
        $this->assertEquals(0, count($response->getOriginalContent()));
    }

    /** @test */
    public function it_adds_non_existant_variation()
    {
        $this->createTax();
        $this->createProductWithThreeVariations();

        $content = [
            'product_id' => "variation-product",
            'quantity' => 1,
            'properties' => ['ORANGE']
        ];

        $response = $this->postJson('/api/cart', $content);
        $response
            ->assertStatus(500);

    }

    /** @test */
    public function it_removes_non_existant_variation()
    {
        $this->createTax();
        $this->createProductWithThreeVariations();

        $this->addVariationProduct(1, ['RED']);

        $response = $this
            ->deleteJson('/api/cart/variation-product-ORANGE');
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'api.product_deleted'
            ]);
    }
}
