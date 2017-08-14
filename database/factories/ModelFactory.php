<?php

use App\Console\Commands\GenerateSiteMap;
use App\Country;
use App\Order;
use App\Property;
use App\PropertyValue;
use App\Billing;
use App\Brand;
use App\BrandService;
use App\Category;
use App\Coupon;
use App\Faq;
use App\Image;
use App\Label;
use App\Lead;
use App\PaymentMethod;
use App\Product;
use App\Review;
use App\Shipment;
use App\Shipping;
use App\ShippingMethod;
use App\Tag;
use App\Tax;
use App\User;
use App\Variation;
use App\Zone;
use App\Cart;
use Carbon\Carbon;
use function Couchbase\fastlzCompress;
use \Faker\Generator;
use MongoDB\BSON\UTCDatetime;

$files = collect(Storage::files('wp_files'))->map(function ($string) {
    return str_replace('wp_files', '', $string);
});

$factory->define(User::class, function (Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Product::class, function (Generator $faker) {
    $name = $faker->words(3, true);
    return [
        '_id' => strtoupper(str_slug($name)),
        'name' => $name,
        'status' => Product::PUBLISHED,
        'introduction' => $faker->paragraphs(1, true),
        'description' => $faker->paragraphs(3, true),
        'is_featured' => $faker->boolean(35),
        'reviews_allowed' => $faker->boolean(),
        'meta_title' => $name,
        'meta_description' => $faker->paragraphs(1, true),
        'meta_slug' => $faker->words(6, true),
        'weight' => $faker->numberBetween(2, 10),
        'length' => $faker->numberBetween(2, 10),
        'width' => $faker->numberBetween(2, 10),
        'height' => $faker->numberBetween(2, 10),
        'email_provider' => $faker->companyEmail
    ];
});

$factory->define(\App\Business\Models\Shop\Product::class, function (Generator $faker) {
    $name = $faker->words(3, true);
    return [
        '_id' => strtoupper(str_slug($name)),
        'name' => $name,
        'status' => Product::PUBLISHED,
        'introduction' => $faker->paragraphs(1, true),
        'description' => $faker->paragraphs(3, true),
        'is_featured' => $faker->boolean(35),
        'reviews_allowed' => $faker->boolean(),
        'meta_title' => $name,
        'meta_description' => $faker->paragraphs(1, true),
        'meta_slug' => $faker->words(6, true)
    ];
});

$factory->state(\App\Business\Models\Shop\Product::class, 'draft', function () {
    return ['status' => Product::DRAFT];
});
$factory->state(\App\Business\Models\Shop\Product::class, 'hidden', function () {
    return ['status' => Product::HIDDEN];
});
$factory->state(\App\Business\Models\Shop\Product::class, 'featured', function () {
    return ['is_featured' => true];
});
$factory->state(Product::class, 'DropShipping', function (Generator $faker) {
    return ['provider' => $faker->email];
});
$factory->state(Product::class, 'bargain', function () {
    return ['is_discounted' => true];
});

$factory->define(Property::class, function (Generator $faker) {
    return [
        'name' => $faker->word,
        'order' => $faker->randomNumber()
    ];
});

$factory->define(PropertyValue::class, function (Generator $faker) {
    return [
        'name' => $faker->word,
        'sku' => $faker->word,
        'complementary_text' => $faker->word
    ];
});

$factory->define(Review::class, function (Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'comment' => $faker->paragraphs(2, true),
        'verified' => true,
        'rating' => $faker->numberBetween(0, 5),
        //Needed because its and embeded document
        'product_id' => $faker->uuid
    ];
});

$factory->define(Label::class, function (Generator $faker) {
    $type = ['Default', 'Primary', 'Success', 'Info', 'Warning', 'Danger'];
    $chosen = $faker->randomElement($type);

    return [
        'name' => $chosen,
        'css' => strtolower($chosen)
    ];
});

$factory->define(Brand::class, function (Generator $faker) use ($files) {
    $name = $faker->words(3, true);
    return [
        'name' => $name,
        //'slug' => str_slug($name) ,
        'description' => $faker->paragraphs(3, true),
        'filename' => $files->random(),
        'featured' => true,
        'meta_title' => $name,
        'meta_description' => $faker->paragraphs(1, true),
        'meta_slug' => $faker->words(6, true)
    ];
});

$factory->define(BrandService::class, function (Generator $faker) {
    $position = ['left', 'right'];
    return [
        'title' => $faker->words(3, true),
        'description' => $faker->paragraphs(3, true),
        'image' => '',
        'position' => $faker->randomElement($position)
    ];
});

$factory->define(Variation::class, function (Generator $faker) use ($files) {
    return [
        'sku' => $faker->slug(),
        //Price is set up before saving
        //'price' => $faker->numberBetween( 10, 250),
        'real_price' => $faker->numberBetween(10, 250),
        'discounted_price' => $faker->numberBetween(1, 10),
        'is_discounted' => $faker->boolean(35),
        'stock' => 10,
        'in_stock' => $faker->boolean(),
        'filename' => $files->random(),
    ];
});

$factory->define(PaymentMethod::class, function (Generator $faker) {
    return [
        'name' => $faker->words(3, true),
        'short_description' => $faker->paragraphs(1, true),
        'description' => $faker->paragraphs(3, true),
        'code' => $faker->slug(2),
        'slug' => $faker->slug(2),
    ];
});

$factory->define(Image::class, function (Generator $faker) use ($files) {
    return [
        'name' => $faker->words(3, true),
        'alt' => $faker->paragraphs(1, true),
        'filename' => $files->random(),
    ];
});

$factory->define(Lead::class, function (Generator $faker) {
    return [
        'email' => $faker->email,
        'type' => $faker->words(1, true)
    ];
});

$factory->define(Category::class, function (Generator $faker) use ($files) {
    $name = $faker->words(3, true);
    return [
        'name' => $name,
        //'slug' => str_slug($name)
        'filename' => $files->random(),
        'products' => 0,
        'featured' => false,
        'meta_title' => $name,
        'meta_description' => $faker->paragraphs(1, true),
        'meta_slug' => $faker->words(6, true)
    ];
});

$factory->define(\App\Business\Models\Shop\Category::class, function (Generator $faker) use ($files) {
    $name = $faker->words(3, true);
    return [
        'name' => $name,
        //'slug' => str_slug($name)
        'filename' => $files->random(),
        'products' => 0,
        'featured' => false,
        //'meta_title' => $name,
        //'meta_description' => $faker->paragraphs(1, true),
        //'meta_slug' => $faker->words(6, true)
    ];
});

$factory->define(Billing::class, function (Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->freeEmail,
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'address_2' => '',
        'city' => $faker->city,
        'postcode' => $faker->postcode,
        'country' => $faker->country,
        'country_id' => $faker->country,
        'province' => 'province',
        'province_id' => 'province_id',
    ];
});

$factory->define(Shipping::class, function (Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->freeEmail,
        'phone' => $faker->phoneNumber,
        'fax' => $faker->phoneNumber,
        'company' => $faker->company,
        'address' => $faker->address,
        'address_2' => '',
        'city' => $faker->city,
        'postcode' => $faker->postcode,
        'country' => $faker->country,
        'country_id' => $faker->country,
        'province' => 'province',
        'province_id' => 'province_id',
    ];
});

$factory->define(Coupon::class, function (Generator $faker) {
    $magnitude = $faker->numberBetween(-4, -5);
    $type = collect([Coupon::DIRECT, Coupon::PERCENTAGE])->random();
    return [
        'name' => str_slug($faker->words(3, true)),
        'magnitude' => $magnitude,
        'type' => $type,
        'target' => Cart::CART_CONDITION_TARGET_ITEM,
        'description' => $faker->paragraph(),
        //'value' => "{$magnitude}{$type}",
        'expired_at' => new UTCDatetime(Carbon::now()->addDays(4)->timestamp * 1000),
        'minimum_cart' => 0,
        'maximum_cart' => null,
        'exclude_sale_items' => $faker->boolean(),

        'limit_usage_by_coupon' => 3,
        'limit_usage_by_user' => 1,
        'single_use' => 1,
        'emails' => $faker->email . ',' . $faker->email . ',' . $faker->email
    ];
});

$factory->define(Zone::class, function (Generator $faker) {
    return [
        'name' => $faker->name,
        'state' => ['C', 'AL', 'B', 'GI'],
    ];
});

$factory->define(ShippingMethod::class, function (Generator $faker) {
    return [
        'name' => $faker->name,
        'cost' => $faker->numberBetween(3, 25),
        'price_condition' => $faker->numberBetween(3, 25),
        'free_shipping' => $faker->boolean
    ];
});

$factory->define(Faq::class, function (Generator $faker) {
    return [
        'name' => $faker->sentence() . ' ?',
        'answer' => $faker->paragraph()
    ];
});

$factory->define(Tax::class, function (Generator $faker) {
    return [
        'country' => $faker->countryCode,
        'state' => '',
        'postcode' => $faker->postcode,
        'city' => $faker->citySuffix,
        'rate' => $faker->numberBetween(10, 25),
        'name' => 'Iva',
        'order' => $faker->randomNumber(),
        'external_id' => $faker->randomNumber()
    ];
});

$factory->define(Order::class, function (Generator $faker) {
    return [
        'status' => Order::NEW,
        "token" => Carbon::now()->timestamp,
        "session_id" => $faker->randomAscii,
        "subtotal" => $faker->randomFloat(2, 0, 25),
        "total" => $faker->randomFloat(2, 0, 25),
        "total_items" => $faker->numberBetween(0, 5),
        "user_agent" => $faker->userAgent,
        //conditions
        "cart" => [
            factory(Cart::class)->make()->toArray()
        ],
        'payment_method_id' => factory(PaymentMethod::class)->lazy([
            'slug' => PaymentMethod::CASH_ON_DELIVERY
        ]),
        'billing' => factory(Billing::class)->make()->toArray(),
        'shipping' => factory(Shipping::class)->make()->toArray()
    ];
});

$factory->state(Order::class, 'New', function () {
    return ['status' => Order::NEW];
});
$factory->state(Order::class, 'ValidData', function () {
    return ['status' => Order::VALID_DATA];
});
$factory->state(Order::class, 'Redirected', function () {
    return ['status' => Order::REDIRECTED];
});
$factory->state(Order::class, 'Confirmed', function () {
    return ['status' => Order::CONFIRMED];
});
$factory->state(Order::class, 'Cancelled', function () {
    return ['status' => Order::CANCELLED];
});
$factory->state(Order::class, 'Undefined', function () {
    return ['status' => Order::UNDEFINED];
});

$factory->state(Order::class, 'CashOnDelivery', function (Generator $faker) {
    return [
        'external_id' => $faker->numberBetween(),
        'status' => Order::CONFIRMED,
        'cart' => [
            factory(Cart::class)->make()->toArray(),
            factory(Cart::class)->make()->toArray(),
            factory(Cart::class)->states('NoEmailProvider')->make()->toArray(),
            factory(Cart::class)->states('OnDemand')->make()->toArray()
        ]
    ];
});


$factory->define(Cart::class, function (Generator $faker) {
    if ($faker->boolean()) {
        $variation = [
            "OSSBY-SOPORTE",
            $faker->colorName . '-' . $faker->colorName,
            $faker->word,
        ];
    } else {
        $variation = ['OSSBY-SOPORTE'];
    }

    return [
        "price" => (string)$faker->randomFloat(2, 15, 50),
        "quantity" => $faker->numberBetween(0, 25),
        "total" => (string)$faker->randomFloat(2, 15, 50),
        "total_without_iva" => 247.93388429752067736,
        "properties" => $variation,
        /*"variation_id" => 4948,*/
        "product_id" => factory(Product::class)->lazy([
            'collection_address' => 'Prova1',
            'collection_address_cash_on_delivery' => 'Prova2',
        ])
    ];
});
$factory->state(Cart::class, 'OnDemand', function () {
    return [
        "product_id" => factory(Product::class)->lazy([
            'delivery_address' => 'Prova3'
        ])
    ];
});
$factory->state(Cart::class, 'NoEmailProvider', function () {
    return [
        "product_id" => factory(Product::class)->lazy([
            'email_provider' => null
        ])
    ];
});

$factory->define(Shipping::class, function (Generator $faker) {
    return [
        "first_name" => $faker->name,
        "last_name" => $faker->lastName,
        "email" => $faker->email,
        "phone" => $faker->e164PhoneNumber,
        "address_1" => $faker->streetAddress,
        "address_2" => null,
        "city" => $faker->city,
        "postcode" => '08105',
        "state" => 'C',
        "country" => 'ES'
    ];
});

$factory->define(Billing::class, function (Generator $faker) {
    return [
        "first_name" => $faker->name,
        "last_name" => $faker->lastName,
        "email" => $faker->email,
        "phone" => $faker->e164PhoneNumber,
        "address_1" => $faker->streetAddress,
        "address_2" => null,
        "city" => $faker->city,
        "postcode" => '08105',
        "state" => 'C',
        "country" => 'ES'
    ];
});

$factory->define(Tag::class, function (Generator $faker) {
    $name = $faker->name;
    return [
        "parent_id" => "",
        "name" => $name,
        //"slug" => str_slug($name), //Using slugableTraig
        "description" => $faker->text(),
        "count" => $faker->randomDigit,
    ];
});

$factory->define(Country::class, function (Generator $faker) {
    return [
        "_id" => $faker->countryCode,
        "name" => $faker->country,
        'active' => $faker->boolean,
        "states" => [
            $faker->randomLetter . $faker->randomLetter
        ],
    ];
});

$factory->define(Shipment::class, function (Generator $faker) {
    return [];
});
