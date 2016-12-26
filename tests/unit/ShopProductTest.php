<?php

use App\Business\Models\Shop\Product;
use App\Image;
use App\Tax;
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

    /** @test */
    public function product_status_is_draft()
    {
        /** @var Product $product */
        $product = factory(Product::class)->states('draft')->create();

        $product_with_scopes = Product::find($product->_id);
        $product_without_scopes = Product::withoutGlobalScopes()->find($product->_id);

        $this->assertEquals(null, $product_with_scopes);
        $this->assertEquals($product->_id, $product_without_scopes->_id);
    }

    /** @test */
    public function product_status_is_published()
    {
        /** @var Product $product */
        $product = factory(Product::class)->create();

        $product_with_scopes = Product::find($product->_id);
        $product_without_scopes = Product::withoutGlobalScopes()->find($product->_id);

        $this->assertEquals($product->_id, $product_with_scopes->_id);
        $this->assertEquals($product->_id, $product_without_scopes->_id);
    }

    /** @test */
    public function product_status_is_hidden()
    {
        /** @var Product $product */
        $product = factory(Product::class)->states('hidden')->create();

        $product_with_scopes = Product::find($product->_id);
        $product_without_scopes = Product::withoutGlobalScopes()->find($product->_id);

        $this->assertEquals($product->_id, $product_with_scopes->_id);
        $this->assertEquals($product->_id, $product_without_scopes->_id);
    }

    /** @test */
    public function product_prices_with_one_variation()
    {
        factory(Tax::class)->create([
            'country' => '',
            'state' => '',
            'postcode' => '',
            'city' => '',
            'rate' => 0,
            'name' => 'Iva',
            'order' => 1,
        ]);
        /** @var Product $product */
        $product = factory(Product::class)->create();
        $variation = factory(Variation::class)->make([
            '_id' => [$product->_id],
            'real_price' => 15,
            'is_discounted' => false
        ]);
        $product->variations()->save($variation);


        $this->assertEquals('15.00&euro;', $product->range_price);
        $this->assertEquals('15.00&euro;', $product->range_real_price);
    }

    /** @test */
    public function product_prices_with_three_variation()
    {
        factory(Tax::class)->create([
            'country' => '',
            'state' => '',
            'postcode' => '',
            'city' => '',
            'rate' => 0,
            'name' => 'Iva',
            'order' => 1,
        ]);
        /** @var Product $product */
        $product = factory(Product::class)->create();
        $variation1 = factory(Variation::class)->make([
            '_id' => [$product->_id],
            'real_price' => 15,
            'is_discounted' => false
        ]);
        $variation2 = factory(Variation::class)->make([
            '_id' => [$product->_id],
            'real_price' => 20,
            'is_discounted' => false
        ]);
        $variation3 = factory(Variation::class)->make([
            '_id' => [$product->_id],
            'real_price' => 25,
            'is_discounted' => false
        ]);
        $product->variations()->saveMany([$variation1, $variation2, $variation3]);

        $product = Product::find($product->_id);

        $this->assertEquals('15.00&euro; - 25.00&euro;', $product->range_price);
        $this->assertEquals('15.00&euro; - 25.00&euro;', $product->range_real_price);

    }

    /** @test */
    public function product_without_prices()
    {
        $product = factory(Product::class)->make();

        $this->assertEquals('-', $product->range_price);
        $this->assertEquals('-', $product->range_real_price);
    }
}