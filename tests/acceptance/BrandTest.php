<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BrandTest extends TestCase
{
    /** */
    public function find_brand_at_home()
    {
        $this->visit('/')
            ->see('Simple Brand')
            ->click('Simple Brand')
            ->see('Simple Product')
            ->see('Variable product 1')
            ->see('Variable product 2')
            ->seePageIs($this->link('brand/simple-brand'))
            ->seeRouteIs('shop.brand', ['slug' => 'simple-brand']);
    }
}
