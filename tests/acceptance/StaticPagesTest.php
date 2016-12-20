<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StaticPagesTest extends TestCase
{
    /** @test */
    public function faq()
    {
        $this->visit(route('faq'))
            ->see('static.faq');
    }
}
