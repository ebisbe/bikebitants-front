<?php

use App\Brand;
use App\BrandService;
use App\Color;
use App\Label;
use App\Product;
use App\Review;
use App\Size;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var Brand $brand */
        $brand = factory(Brand::class)->create();

        $brand->services()->save(factory(BrandService::class)->make());
        $brand->services()->save(factory(BrandService::class)->make());
        $brand->services()->save(factory(BrandService::class)->make());

        for ($x = 0; $x <= 5; $x++) {
            $product = $this->product();
            $brand->products()->save($product);
        }
    }

    public function product()
    {
        /** @var Product $product */
        $product = factory(Product::class)->create();

        $product->colors()->save(factory(Color::class)->make());
        $product->colors()->save(factory(Color::class)->make());
        $product->colors()->save(factory(Color::class)->make());

        $product->sizes()->save(factory(Size::class)->make([
            'name' => 'L',
            'complementary_text' => '60-62cm'
        ]));
        $product->sizes()->save(factory(Size::class)->make([
            'name' => 'M',
            'complementary_text' => '57-59cm'
        ]));
        $product->sizes()->save(factory(Size::class)->make([
            'name' => 'S',
            'complementary_text' => '54-56cm'
        ]));

        $product->reviews()->save(factory(Review::class)->make());
        /** @var Review $review */
        $review = $product->reviews()->save(factory(Review::class)->make());
        $review->children()->save(factory(Review::class)->make());
        $review->children()->save(factory(Review::class)->make());
        $product->reviews()->save(factory(Review::class)->make());
        $product->reviews()->save(factory(Review::class)->make());

        $product->labels()->save(factory(Label::class)->make());
        $product->labels()->save(factory(Label::class)->make());
        $product->labels()->save(factory(Label::class)->make());

        return $product;
    }
}
