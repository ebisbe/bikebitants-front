<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BargainTest extends TestCase
{
    /** @test */
    public function view_bargains()
    {
        $this->visit(route('shop.bargain'))
            ->see('Variable Product 2')
            ->see('Oferta Bikebitants')
            ->see('layout.shop')
            ->see('bargain.title')
            ->see('bargain.description')
            ->dontSee('Simple Product')
        ;
    }
}
