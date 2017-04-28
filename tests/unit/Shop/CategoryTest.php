<?php

namespace Tests\Unit\Shop;

use App\Business\Models\Shop\Category;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    protected function tearDown()
    {
        Category::truncate();
    }

    /** @test */
    public function it_has_empty_filename()
    {
        $category = factory(Category::class)->create(['filename' => '']);

        $this->assertEquals('not-found.jpeg', $category->filename);
    }
}
