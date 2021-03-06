<?php

use App\Brand;
use App\Category;
use App\Coupon;
use App\Faq;
use App\Image;
use App\Label;
use App\Product;
use App\Property;
use App\PropertyValue;
use App\Tax;
use App\Variation;
use Illuminate\Database\Seeder;

class TestSuiteData extends Seeder
{
    /** @var Brand $brand */
    protected $brand;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->brand = factory(Brand::class)->create([
            'name' => 'Simple Brand'
        ]);

        factory(Tax::class)->create([
            'country' => '',
            'state' => '',
            'postcode' => '',
            'city' => '',
            'rate' => 21.00,
            'name' => 'IVA'
        ]);
//
//        $this->brand->services()->save(factory(BrandService::class)->make());
//        $this->brand->services()->save(factory(BrandService::class)->make());
//        $this->brand->services()->save(factory(BrandService::class)->make());
//
        $this->categories();
        $this->discounts();

        /*factory(User::class)->create([
            'name' => 'Admin',
            'email' => 'enricu@gmail.com',
            'password' => bcrypt('123456'),
        ]);*/

        Artisan::call('cache:clear');
    }

    /**
     * Create a new product
     * @param bool $variable
     * @param array $type
     * @return Product
     */
    public function product($variable = false, $type = [], $is_discounted)
    {
        /** @var Product $product */
        $product = factory(Product::class)->create($type);

        if ($variable) {
            /** @var Property $size */
            $size = $product->properties()->save(factory(Property::class)->make(['name' => 'size', 'order' => 1]));

            $size->properties_values()->save(factory(PropertyValue::class)->make([
                '_id' => 'L',
                'name' => 'L',
                'complementary_text' => '60-62cm'
            ]));
            $size->properties_values()->save(factory(PropertyValue::class)->make([
                '_id' => 'M',
                'name' => 'M',
                'complementary_text' => '57-59cm'
            ]));
            $size->properties_values()->save(factory(PropertyValue::class)->make([
                '_id' => 'S',
                'name' => 'S',
                'complementary_text' => '54-56cm'
            ]));

            /** @var Property $color */
            $color = $product->properties()->save(factory(Property::class)->make(['name' => 'color', 'order' => 2]));

            $color->properties_values()->save(factory(PropertyValue::class)->make([
                '_id' => 'R',
                'name' => 'Red',
                'complementary_text' => ''
            ]));
            $color->properties_values()->save(factory(PropertyValue::class)->make([
                '_id' => 'GR',
                'name' => 'Green',
                'complementary_text' => ''
            ]));
            $color->properties_values()->save(factory(PropertyValue::class)->make([
                '_id' => 'GO',
                'name' => 'Gold',
                'complementary_text' => ''
            ]));
            $color->properties_values()->save(factory(PropertyValue::class)->make([
                '_id' => 'BR',
                'name' => 'Brown',
                'complementary_text' => ''
            ]));
            $color->properties_values()->save(factory(PropertyValue::class)->make([
                '_id' => 'BL',
                'name' => 'Blue',
                'complementary_text' => ''
            ]));
            $color->properties_values()->save(factory(PropertyValue::class)->make([
                '_id' => 'YL',
                'name' => 'Yellow',
                'complementary_text' => ''
            ]));

            $sizes = $size->properties_values()->get()->pluck('_id')->toArray();
            $colours = $color->properties_values()->get()->pluck('_id')->toArray();

            $arguments = [
                [$product->_id],
                $sizes,
                $colours
            ];
        } else {
            $arguments = [[$product->_id]];
        }

        $reflectionClass = new ReflectionClass('\Hoa\Math\Combinatorics\Combination\CartesianProduct');
        $cartesian = $reflectionClass->newInstanceArgs($arguments);
        foreach ($cartesian as $tuple) {
            if (rand(1, 10) <= 3 && count($cartesian) > 1) {
                continue;
            }

            $product->variations()->save(factory(Variation::class)->make([
                '_id' => $tuple,
                'sku' => implode('-', $tuple),
                'real_price' => 10,
                'discounted_price' => 5,
                'is_discounted' => $is_discounted
            ]));
        }

        $product->images()->save(factory(Image::class)->make());
        $product->images()->save(factory(Image::class)->make());
        $product->images()->save(factory(Image::class)->make());
        $product->images()->save(factory(Image::class)->make());

//        $product->reviews()->save(factory(Review::class)->make());
//        /** @var Review $review */
//        $review = $product->reviews()->save(factory(Review::class)->make());
//        $review->children()->save(factory(Review::class)->make());
//        $review->children()->save(factory(Review::class)->make());
//        $product->reviews()->save(factory(Review::class)->make());
//        $product->reviews()->save(factory(Review::class)->make());

        $product->labels()->save(factory(Label::class, 1)->make());
        $product->faqs()->saveMany(factory(Faq::class, 5)->make());

        return $product;
    }

    /**
     * Create tree category structure
     */
    public function categories()
    {

        $categories = collect([
            ['name' => 'Category 1',
                'subcategories' => collect([
                    [
                        'name' => 'Subcategory 1',
                        'featured' => 1,
                        'variable' => false,
                        'prod_options' => [
                            '_id' => 'simple-product',
                            'name' => 'Simple Product',
                            'is_featured' => true
                        ]
                    ],
                    [
                        'name' => 'Subcategory 2',
                        'featured' => 2, 'variable' => true,
                        'prod_options' => [
                            '_id' => 'variable-product-1',
                            'name' => 'Variable Product 1',
                            'is_featured' => true
                        ]
                    ],
                    [
                        'name' => 'Subcategory 3',
                        'featured' => 3,
                        'variable' => true,
                        'prod_options' => [
                            '_id' => 'variable-product-2',
                            'name' => 'Variable Product 2',
                            'is_featured' => true,
                            'is_discounted' => true
                        ]
                    ],
                ])]
        ]);

        $order = 1;
        $categories->each(function ($item) use (&$order) {
            /** @var Category $cat */
            $cat = factory(Category::class)->create([
                'name' => $item['name'],
                'order' => $order++,
                'featured' => !empty($item['featured']) ? $item['featured'] : false,
            ]);
            $total_products = 0;
            if (isset($item['subcategories'])) {
                $subOrder = 1;
                $item['subcategories']->each(function ($item) use ($cat, &$subOrder, &$total_products) {
                    if (is_array($item)) {
                        $name = $item['name'];
                        $featured = $item['featured'];
                    } else {
                        $name = $item;
                        $featured = false;
                    }
                    /** @var Category $child */
                    $child = factory(Category::class)->create([
                        'name' => $name,
                        'order' => $subOrder++,
                        'featured' => $featured,
                    ]);
                    $child->father()->associate($cat);

                    $product = $this->product($item['variable'], $item['prod_options'], $item['prod_options']['is_discounted'] ?? false);
                    $this->brand->products()->save($product);
                    $child->products()->save($product);

                    $child->products_count = 1;
                    $child->save();

                    $total_products += 1;
                });
            }

            $cat->products_count = $total_products;
            $cat->save();
        });
    }

    /**
     * Create discounts
     */
    public function discounts()
    {
        factory(Coupon::class)->create(['name' => 'DISCOUNT10', 'type' => Coupon::PERCENTAGE, 'magnitude' => '-10']);
        factory(Coupon::class)->create(['name' => 'DISCOUNT20', 'type' => Coupon::PERCENTAGE, 'magnitude' => '-20']);
        factory(Coupon::class)->create(['name' => 'DISCOUNT30', 'type' => Coupon::PERCENTAGE, 'magnitude' => '-30']);
    }
}
