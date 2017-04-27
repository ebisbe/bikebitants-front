<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class StaticPagesTest extends TestCase
{
    /** @test */
    public function faq()
    {
        $response = $this->get(route('faq'));
        $response
            ->assertStatus(200)
            ->assertSee('static.faq');
    }
}
