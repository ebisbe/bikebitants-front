<?php

use App\Business\Models\Shop\Product;
use App\Image;
use App\Variation;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShopProductTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function product_does_not_have_images()
    {
        /** @var Product $product */
        $product = factory(Product::class)->make();
        //act
        $front_image = $product->front_image;
        $front_image_hover = $product->front_image_hover;
        //assert
        $this->assertEquals('not-found.jpg', $front_image->filename);
        $this->assertEquals('not-found.jpg', $front_image_hover->filename);
        $this->assertEquals('Image not found', $front_image->name);
        $this->assertEquals('Image not found', $front_image_hover->name);

    }

    /** @test */
    public function product_has_two_images()
    {
        /** @var Product $product */
        $product = factory(Product::class)->create();
        $image = factory(Image::class)->make(['name' => 'Front', 'filename' => 'front_image.jpg']);
        $product->images()->save($image);
        $image = factory(Image::class)->make(['name' => 'Hover', 'filename' => 'front_image_hover.jpg']);
        $product->images()->save($image);

        //act
        $front_image = $product->front_image;
        $front_image_hover = $product->front_image_hover;

        //assert
        $this->assertEquals('Front', $front_image->name);
        $this->assertEquals('front_image.jpg', $front_image->filename);
        $this->assertEquals('Hover', $front_image_hover->name);
        $this->assertEquals('front_image_hover.jpg', $front_image_hover->filename);
    }

    /** @test */
    public function product_has_no_stock()
    {
        /** @var Product $product */
        $product = factory(Product::class)->make();


        $this->assertEquals('catalogue.out_of_stock', $product->stock_label);
    }

    /** @test */
    public function product_has_low_stock()
    {
        /** @var Product $product */
        $product = factory(Product::class)->create(['stock' => '4']);

        $this->assertEquals('catalogue.in_stock ( 4 )', $product->stock_label);
    }

    /** @test */
    public function product_has_stock()
    {
        /** @var Product $product */
        $product = factory(Product::class)->create(['stock' => '6']);

        $this->assertEquals('catalogue.in_stock', $product->stock_label);
    }
}
