<?php

namespace Tests\Unit\WooCoomerce;

use App\Business\Integration\WooCommerce\Models\Image;
use App\Business\Integration\WooCommerce\Models\Product;

class ProductStatysSyncroTest extends \TestCase
{
    /** @var  Product  */
    protected $service;

    protected function setUp()
    {
        $this->service = new Product();
    }

    /** @test */
    public function import_draft_product()
    {
        $this->assertEquals(1, $this->service->statusSyncro('draft', 'whatever'));
    }

    /** @test */
    public function import_published_product()
    {
        $this->assertEquals(2, $this->service->statusSyncro('publish', 'whatever'));
    }

    /** @test */
    public function import_published_but_hidden_product()
    {
        $this->assertEquals(3, $this->service->statusSyncro('publish', 'hidden'));
    }

    /** @test */
    public function import_published_but_shearchable_product()
    {
        $this->assertEquals(3, $this->service->statusSyncro('publish', 'search'));
    }

    /** @test */
    public function import_unknown_status_product()
    {
        $this->assertEquals(-1, $this->service->statusSyncro('whatever', 'whatever'));
    }

    /** @test */
    public function get_encoded_name_from_url()
    {
        $image = new Image();
        list($url, $name) = $image->encodeSrc('http://www.example.com/diseño.jpg');

        $this->assertEquals('http://www.example.com/', $url);
        $this->assertEquals('dise%C3%B1o.jpg', $name);
    }
}
