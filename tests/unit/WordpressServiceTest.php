<?php

namespace Tests\Unit;

use App\Business\Services\WordpressService;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WordpressServiceTest extends \TestCase
{
    /** @var  WordpressService  */
    protected $service;

    protected function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->service = new WordpressService();
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
        list($url, $name) = $this->service->encodeSrc('http://www.example.com/diseño.jpg');

        $this->assertEquals('http://www.example.com/', $url);
        $this->assertEquals('dise%C3%B1o.jpg', $name);
    }
}