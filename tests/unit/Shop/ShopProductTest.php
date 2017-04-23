<?php
namespace Test\Unit\Shop;

use App\Brand;
use App\Business\Models\Shop\Category;
use App\Business\Models\Shop\Product;
use App\Business\Traits\Tests\ProductTrait;
use App\Image;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ShopProductTest extends \TestCase
{
    use ProductTrait;

    /** @test */
    public function product_does_not_have_images()
    {
        /** @var Product $product */
        $product = factory(Product::class)->make();
        //act
        $front_image = $product->front_image;
        $front_image_hover = $product->front_image_hover;
        //assert
        $this->assertEquals('not-found.jpeg', $front_image->filename);
        $this->assertEquals('not-found.jpeg', $front_image_hover->filename);
        $this->assertEquals('Image not found', $front_image->name);
        $this->assertEquals('Image not found', $front_image_hover->name);
    }

    /** @test */
    public function product_has_no_filename_in_image()
    {
        /** @var Product $product */
        $product = factory(Product::class)->create();
        $image = factory(Image::class)->make(['name' => 'Front', 'filename' => '']);
        $product->images()->save($image);
        $image = factory(Image::class)->make(['name' => 'Hover', 'filename' => '']);
        $product->images()->save($image);

        //act
        $front_image = $product->front_image;
        $front_image_hover = $product->front_image_hover;

        $this->assertEquals('not-found.jpeg', $front_image->filename);
        $this->assertEquals('not-found.jpeg', $front_image_hover->filename);
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

        $this->assertEquals(null, $product_with_scopes);
        $this->assertEquals($product->_id, $product_without_scopes->_id);
    }

    /** @test */
    public function product_prices_with_one_variation()
    {
        $this->createTax();
        $product = $this->createSimpleProduct();

        $this->assertEquals('10.00&euro;', $product->range_price);
        $this->assertEquals('10.00&euro;', $product->range_real_price);
    }

    /** @test */
    public function product_prices_with_one_variation_without_price()
    {
        $this->createTax();
        $product = $this->createSimpleProduct(10, 0);

        $this->assertEquals('-', $product->range_price);
        $this->assertEquals('-', $product->range_real_price);
    }

    /** @test */
    public function product_prices_with_three_variation()
    {
        $this->createTax();
        $product = $this->createProductWithThreeVariations();

        $this->assertEquals('10.00&euro; - 20.00&euro;', $product->range_price);
        $this->assertEquals('10.00&euro; - 20.00&euro;', $product->range_real_price);
    }

    /** @test */
    public function product_prices_with_three_variations_and_without_lower_price()
    {
        $this->createTax();
        $product = $this->createProductWithThreeVariations([0, 15, 20]);

        $this->assertEquals('15.00&euro; - 20.00&euro;', $product->range_price);
        $this->assertEquals('15.00&euro; - 20.00&euro;', $product->range_real_price);
    }

    /** @test */
    public function product_without_prices()
    {
        $product = factory(Product::class)->make();

        $this->assertEquals('-', $product->range_price);
        $this->assertEquals('-', $product->range_real_price);
    }

    /** @test */
    public function product_without_meta_title()
    {
        $product = factory(Product::class)->create(['name' => 'Product 1', 'meta_title' => '']);

        $this->assertEquals('Product 1 | Bikebitants', $product->title);
    }

    /** @test */
    public function product_with_meta_title()
    {
        $product = factory(Product::class)->create(['name' => 'Product 1', 'meta_title' => 'Meta title']);

        $this->assertEquals('Meta title | Bikebitants', $product->title);
    }

    /** @test */
    public function product_with_meta_title_from_yoast()
    {
        $product = factory(Product::class)->create([
            'name' => 'Product 1',
            'meta_title' => '%%title%%. Tienda Online %%sep%% %%sitename%%'
        ]);

        $this->assertEquals('Product 1. Tienda Online | Bikebitants', $product->title);
    }

    /** @test */
    public function product_without_meta_description()
    {
        $product = factory(Product::class)->create(['introduction' => 'Product 1', 'meta_description' => '']);

        $this->assertEquals('Product 1', $product->meta_desc);
    }

    /** @test */
    public function product_with_meta_description()
    {
        $product = factory(Product::class)->create(['name' => 'Product 1', 'meta_description' => 'Meta description']);

        $this->assertEquals('Meta description', $product->meta_desc);
    }

    /** @test */
    public function get_lower_price()
    {
        $this->createTax();
        $product = $this->createProductWithThreeVariations([0, 15, 20]);

        $this->assertEquals(15, $product->lower_price);
    }

    /** @test */
    public function it_gets_higher_price()
    {
        $this->createTax();
        $product = $this->createProductWithThreeVariations([0, 15, 20]);

        $this->assertEquals(20, $product->higher_price);
    }

    /** @test */
    public function get_lower_price_with_product_without_price()
    {
        $this->createTax();
        $product = $this->createProductWithThreeVariations([0, 0, 0]);

        $this->assertEquals('-', $product->lower_price);
    }

    /** @test */
    public function it_gets_higher_price_with_product_without_price()
    {
        $this->createTax();
        $product = $this->createProductWithThreeVariations([0, 0, 0]);

        $this->assertEquals('-', $product->higher_price);
    }

    /** @test */
    public function convert_product_to_ga_object_without_viewname_and_position()
    {
        $product = $this->createSimpleProduct();

        $expected = [
            'id' => 'simple-product',
            'name' => 'Simple Product',
            'brand' => 'Simple Brand',
            'category' => 'Sub Category 1',
        ];

        $this->assertEquals(json_encode($expected), $product->gaProduct());
    }

    /** @test */
    public function convert_product_to_ga_object_with_viewname_and_position()
    {
        $product = $this->createSimpleProduct();

        $expected = [
            'id' => 'simple-product',
            'name' => 'Simple Product',
            'brand' => 'Simple Brand',
            'category' => 'Sub Category 1',
            'list' => 'test',
            'position' => 2
        ];

        $this->assertEquals(json_encode($expected), $product->gaProduct('test', 2));
    }

    /** @test */
    public function convert_product_to_ga_object_without_brand()
    {
        $product = factory(Product::class)->create([
            '_id' => 'simple-product',
            'name' => 'Simple Product'
        ]);

        $category = factory(\App\Category::class)->create(['name' => 'Simple Category', 'products_count' => 1]);
        $category->products()->save($product);

        $expected = [
            'id' => 'simple-product',
            'name' => 'Simple Product',
            'category' => 'Simple Category',
        ];

        $this->assertEquals(json_encode($expected), $product->fresh()->gaProduct());
    }

    /** @test */
    public function convert_product_to_ga_object_without_category()
    {
        $product = factory(Product::class)->create([
            '_id' => 'simple-product',
            'name' => 'Simple Product'
        ]);

        $brand = factory(Brand::class)->create(['name' => 'Simple Brand']);
        $brand->products()->save($product);

        $expected = [
            'id' => 'simple-product',
            'name' => 'Simple Product',
            'brand' => 'Simple Brand',
        ];

        $this->assertEquals(json_encode($expected), $product->gaProduct());
    }
}
