<?php

use App\Attribute;
use App\AttributeValue;
use App\Brand;
use App\BrandService;
use App\Color;
use App\Label;
use App\Product;
use App\Review;
use App\Size;
use App\Variation;
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

        $product = $this->product('simple');
        $brand->products()->save($product);

        $product = $this->product('variable');
        $brand->products()->save($product);
    }

    public function product($type)
    {
        /** @var Product $product */
        $product = factory(Product::class)->create(['slug' => $type]);

        if ($type == 'variable') {

            /** @var Attribute $size */
            $size = $product->attributes()->save(factory(Attribute::class)->make(['name' => 'size', 'order' => 1]));

            $size->attribute_values()->save(factory(AttributeValue::class)->make([
                '_id' => 'L',
                'name' => 'L',
                'complementary_text' => '60-62cm'
            ]));
            $size->attribute_values()->save(factory(AttributeValue::class)->make([
                '_id' => 'M',
                'name' => 'M',
                'complementary_text' => '57-59cm'
            ]));
            $size->attribute_values()->save(factory(AttributeValue::class)->make([
                '_id' => 'S',
                'name' => 'S',
                'complementary_text' => '54-56cm'
            ]));

            /** @var Attribute $color */
            $color = $product->attributes()->save(factory(Attribute::class)->make(['name' => 'color', 'order' => 2]));

            $color->attribute_values()->save(factory(AttributeValue::class)->make([
                '_id' => 'RED',
                'name' => 'Red',
                'complementary_text' => ''
            ]));
            $color->attribute_values()->save(factory(AttributeValue::class)->make([
                '_id' => 'GREEN',
                'name' => 'Green',
                'complementary_text' => ''
            ]));
            $color->attribute_values()->save(factory(AttributeValue::class)->make([
                '_id' => 'GOLD',
                'name' => 'Gold',
                'complementary_text' => ''
            ]));

            $colours = $color->attribute_values()->get();
            $sizes = $size->attribute_values()->get();
            foreach ($sizes as $size) {
                foreach ($colours as $color) {
                    $product->variation()->save(factory(Variation::class)->make([
                        '_id' => [$color->_id, $size->_id]
                    ]));
                }
            }
        }

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
