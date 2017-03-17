<?php

namespace Tests\Unit\Shop;

use App\Business\Models\Shop\Category;

class CategoryTest extends \TestCase
{
    /** @test */
    public function category_has_empty_filename()
    {
        $category = factory(Category::class)->create(['filename' => '']);

        $this->assertEquals('not-found.jpeg', $category->filename);
    }
}
