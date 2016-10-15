<?php

use App\Attribute;
use App\AttributeValue;
use App\Brand;
use App\BrandService;
use App\Category;
use App\Coupon;
use App\Faq;
use App\Image;
use App\Label;
use App\Product;
use App\Review;
use App\ShippingMethod;
use App\User;
use App\Variation;
use App\Zone;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
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
            'name' => 'cum-aliquid-enim'
        ]);

        $this->brand->services()->save(factory(BrandService::class)->make());
        $this->brand->services()->save(factory(BrandService::class)->make());
        $this->brand->services()->save(factory(BrandService::class)->make());

        $this->categories();
        $this->discounts();
        $this->zones();

        factory(User::class)->create([
            'name' => 'Admin',
            'email' => 'enricu@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        Artisan::call('cache:clear');

    }

    /**
     * Create a new product
     * @param bool $variable
     * @param array $type
     * @return Product
     */
    public function product($variable = false, $type = [])
    {
        /** @var Product $product */
        $product = factory(Product::class)->create($type);

        if ($variable) {
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
                '_id' => 'R',
                'name' => 'Red',
                'complementary_text' => ''
            ]));
            $color->attribute_values()->save(factory(AttributeValue::class)->make([
                '_id' => 'GR',
                'name' => 'Green',
                'complementary_text' => ''
            ]));
            $color->attribute_values()->save(factory(AttributeValue::class)->make([
                '_id' => 'GO',
                'name' => 'Gold',
                'complementary_text' => ''
            ]));
            $color->attribute_values()->save(factory(AttributeValue::class)->make([
                '_id' => 'BR',
                'name' => 'Brown',
                'complementary_text' => ''
            ]));
            $color->attribute_values()->save(factory(AttributeValue::class)->make([
                '_id' => 'BL',
                'name' => 'Blue',
                'complementary_text' => ''
            ]));
            $color->attribute_values()->save(factory(AttributeValue::class)->make([
                '_id' => 'YL',
                'name' => 'Yellow',
                'complementary_text' => ''
            ]));

            $sizes = $size->attribute_values()->get()->pluck('_id')->toArray();
            $colours = $color->attribute_values()->get()->pluck('_id')->toArray();

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
            if(rand(1,10) <= 3) {
                continue;
            }

            $product->variations()->save(factory(Variation::class)->make([
                '_id' => $tuple,
                'sku' => implode('-', $tuple)
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
            ['name' => 'Accesorios bicicleta',
                'subcategories' => collect([
                    'Antirrobo',
                    'Electrónica',
                    'Guardabarros',
                    'Soporte Móvil',
                    ['name' =>'Timbres', 'featured' => 2],
                ])],
            ['name' => 'Cascos bicicleta',
                'subcategories' => collect([
                    'Casco Airbag',
                    'Cascos plegables',
                ])],
            ['name' => 'Complementos ciclista',
                'subcategories' => collect([
                    'Mochilas y bolsas',
                ])],
            ['name' => 'Infantil',
                'featured' => 3,
                'subcategories' => collect([
                    'Bicicletas sin pedales',
                    'Cascos para niños',
                    'Remolque',
                    'Silla portabebes',
                    'Timbres para niños'
                ])],
            ['name' => 'Luces bicicleta',
                'featured' => 1,
                'subcategories' => collect([
                    'Intermitentes',
                    'Luz delantera',
                    'Luz trasera',
                ])],
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
                    if(is_array($item)) {
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

                    $cont = 0;
                    while ($cont++ < 5) {
                        $product = $this->product(rand(0, 1), ['categories' => [$cat->slug, $child->slug]]);
                        $this->brand->products()->save($product);
                        $child->products()->save($product);
                    }
                    $child->products = $cont;
                    $child->save();

                    $total_products += $cont;
                });
            }

            $cat->products = $total_products;
            $cat->save();
        });
    }

    /**
     * Create discounts
     */
    public function discounts()
    {
        factory(Coupon::class)->create(['name' => 'DISCOUNT10']);
        factory(Coupon::class)->create(['name' => 'DISCOUNT20']);
        factory(Coupon::class)->create(['name' => 'DISCOUNT30']);
    }

    /**
     * Create Zones
     */
    public function zones()
    {
        $zonesCol = collect([
            [
                'name' => 'España (Península)',
                'region' => ['C', 'VI', 'AB', 'A', 'AL', 'O', 'AV', 'BA', 'B', 'BU', 'CC', 'CA', 'S', 'CS', 'CR', 'CO', 'CU', 'GI', 'GR', 'GU', 'SS', 'H', 'HU', 'J', 'LO', 'LE', 'L', 'LU', 'M', 'MA', 'MU', 'NA', 'OR', 'P', 'PO', 'SA', 'SG', 'SE', 'SO', 'T', 'TE', 'TO', 'V', 'VA', 'BI', 'ZA', 'Z'],
                'shippingMethods' => collect([
                    ['name' => 'Envío 24-48 horas',
                        'cost' => 3.305785123966942,
                        'price_condition' => 0],
                    ['name' => 'Envío gratuito 24-48 horas',
                        'cost' => 0,
                        'price_condition' => 25]
                ])
            ],
            [
                'name' => 'España (Baleares)',
                'region' => ['PM'],
                'shippingMethods' => collect([
                    ['name' => 'Envío 3-4 días',
                        'cost' => 8.264462809917355,
                        'price_condition' => 0],
                    ['name' => 'Envío gratuito 3-4 dias',
                        'cost' => 0,
                        'price_condition' => 25]
                ])
            ],
            [
                'name' => 'España (Canarias)',
                'region' => ['GC', 'TF'],
                'shippingMethods' => collect([
                    ['name' => 'Envío 3-4 dias',
                        'cost' => 25,
                        'price_condition' => 0]
                ])
            ],
            [
                'name' => 'España (Ceuta Melilla)',
                'region' => ['CE', 'ML'],
                'shippingMethods' => collect([
                    ['name' => 'Envío 3-4 dias',
                        'cost' => 25,
                        'price_condition' => 0]
                ])
            ],
        ]);

        $zonesCol->each(function ($item, $key) {
            /** @var Zone $zone */
            $zone = factory(Zone::class)->create([
                'name' => $item['name'],
                'region' => $item['region']
            ]);
            $item['shippingMethods']->each(function ($item, $key) use ($zone) {
                /** @var Category $child */
                $shippingMethod = factory(ShippingMethod::class)->make([
                    'name' => $item['name'],
                    'cost' => $item['cost'],
                    'price_condition' => $item['price_condition'],
                ]);
                $zone->shippingMethods()->save($shippingMethod);
            });
        });
    }
}
