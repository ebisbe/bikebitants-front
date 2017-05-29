<?php

namespace Tests\Feature;

use App\Business\Repositories\ProductRepository;
use App\Business\Services\CartService;
use Tests\TestCase;
use Mockery;

class CartServiceTest extends TestCase
{

    /** @var  CartSErvice $service */
    private $service;

    protected function setUp()
    {
        parent::setUp();
        $productRepository = Mockery::mock(ProductRepository::class);
        $this->service = new CartService($productRepository);
    }

    /** @test */
    public function it_finds_we_are_at_max_stock()
    {
        $this->service->setQuantity(1);
        $this->service->setStock(2);

        $this->assertTrue($this->service->isMaxStock(1));
    }

    /** @test */
    public function it_checks_we_have_stock()
    {
        $this->service->setQuantity(1);
        $this->service->setStock(3);

        $this->assertFalse($this->service->isMaxStock(1));
    }

    /** @test */
    public function it_checks_max_stock_with_dropshipping()
    {
        $this->service->setQuantity(10);
        $this->service->setStock(null);

        $this->assertFalse($this->service->isMaxStock(1));
    }

    /** @test */
    public function it_gets_quantity_to_store_in_cart()
    {
        $this->service->setQuantity(1);
        $this->service->setStock(10);

        $this->assertEquals(1, $this->service->getQuantity());

        $this->service->setQuantity(5);
        $this->assertEquals(4, $this->service->getQuantity(6));
    }

    /** @test */
    public function it_gets_quantity_with_dropshipping()
    {
        $this->service->setQuantity(100);
        $this->service->setStock(null);

        $this->assertEquals(100, $this->service->getQuantity());
    }
}
