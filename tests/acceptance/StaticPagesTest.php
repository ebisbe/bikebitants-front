<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StaticPagesTest extends BrowserKitTest
{
    /** @test */
    public function faq()
    {
        $this->visit(route('faq'))
            ->see('static.faq');
    }
}
