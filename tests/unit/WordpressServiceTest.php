<?php

namespace Tests\Unit;

use App\Business\Services\WordpressService;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WordpressServiceTest extends \TestCase
{

    /** @test */
    public function import_draft_product()
    {
        $service = new WordpressService();

        $this->assertEquals(1, $service->statusSyncro('draft', 'whatever'));
    }

    /** @test */
    public function import_published_product()
    {
        $service = new WordpressService();

        $this->assertEquals(2, $service->statusSyncro('publish', 'whatever'));
    }

    /** @test */
    public function import_published_but_hidden_product()
    {
        $service = new WordpressService();

        $this->assertEquals(3, $service->statusSyncro('publish', 'hidden'));
    }

    /** @test */
    public function import_published_but_shearchable_product()
    {
        $service = new WordpressService();

        $this->assertEquals(3, $service->statusSyncro('publish', 'search'));
    }

    /** @test */
    public function import_unknown_status_product()
    {
        $service = new WordpressService();

        $this->assertEquals(-1, $service->statusSyncro('whatever', 'whatever'));
    }
}
