<?php

namespace Tests\Unit\Shop;

use App\Business\Models\Shop\Category;

class CategoryPresenterTest extends \TestCase
{

    /** @test */
    public function show_meta_title_from_category_without_father()
    {
        /** @var Category $category */
        $category = factory(Category::class)->create(['name' => 'Category 1']);

        $this->assertEquals('Category 1. Tienda online | Bikebitants', $category->title);
    }

    /** @test */
    public function show_meta_title_from_category_with_father()
    {
        /** @var Category $categoryFather */
        $categoryFather = factory(Category::class)->create(['name' => 'Category Father']);
        /** @var Category $categoryChild */
        $categoryChild = factory(Category::class)->create(['name' => 'Category Child']);
        $categoryFather->children()->save($categoryChild);

        $this->assertEquals(
            'Category Child. Category Father. Tienda online | Bikebitants',
            $categoryChild->fresh()->title
        );
    }

    /** @test */
    public function show_meta_description()
    {
        /** @var Category $category */
        $category = factory(Category::class)->create(['name' => 'Category 1']);

        $this->assertEquals(
            'La mejor selección en Category 1 para cubrir todas la necesidades del ciclista urbano. Envío gratuito y devolución fácil.',
            $category->fresh()->meta_description
        );
    }
}