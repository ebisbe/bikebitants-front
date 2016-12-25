<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

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
use App\Shipping;
use App\ShippingMethod;
use App\Tax;
use App\User;
use App\Variation;
use App\Zone;
use Carbon\Carbon;
use \Faker\Generator;
use MongoDB\BSON\UTCDatetime;


$files = collect(Storage::files('wp_files'))->map(function($string) {
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
        //'slug' => str_slug($name),
        'introduction' => $faker->paragraphs(1, true),
        'description' => $faker->paragraphs(3, true),
        'is_featured' => $faker->boolean(35),
        //'is_discounted' => $faker->boolean(35),
        //'min_price' => $faker->numberBetween(1, 10),
        //'max_price' => $faker->numberBetween(1, 10),
        //'discount_init' => $faker->date(),
        //'discount_end' => $faker->date(),
        'tags' => $faker->words(),
        'reviews_allowed' => $faker->boolean(),
        //'rating' => $faker,
        //'video' => 'http://www.youtube.com/embed/M4z90wlwYs8?feature=player_detailpage'
        'meta_title' => $name,
        'meta_description' => $faker->paragraphs(1, true),
        'meta_slug' => $faker->words(6, true)
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
        'tags' => $faker->words(),
        'reviews_allowed' => $faker->boolean(),
        'meta_title' => $name,
        'meta_description' => $faker->paragraphs(1, true),
        'meta_slug' => $faker->words(6, true)
    ];
});

$factory->state(\App\Business\Models\Shop\Product::class, 'draft', function () {
    return [
        'status' => Product::DRAFT,
    ];
});

$factory->state(\App\Business\Models\Shop\Product::class, 'hidden', function () {
    return [
        'status' => Product::HIDDEN,
    ];
});

$factory->state(Product::class, 'bargain', function () {
    return [
        'is_discounted' => true,
    ];
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
        'rating' => $faker->numberBetween(0, 5)
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
        '_id' => $faker->slug(),
        'sku' => $faker->slug(),
        //Price is set up before saving
        //'price' => $faker->numberBetween( 10, 250),
        'real_price' => $faker->numberBetween(10, 250),
        'discounted_price' => $faker->numberBetween(1, 10),
        'is_discounted' => $faker->boolean(35),
        'stock' => /*$faker->numberBetween(0,3)*/
            10,
        'filename' => $files->random(),
    ];
});

$factory->define(PaymentMethod::class, function (Generator $faker) {
    return [
        'name' => $faker->words(3, true),
        'short_description' => $faker->paragraphs(1, true),
        'description' => $faker->paragraphs(3, true),
        'code' => $faker->slug(2),
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
        'description' => $faker->paragraph(),
        //'value' => "{$magnitude}{$type}",
        'expired_at' => New UTCDatetime(Carbon::now()->addDays(4)->timestamp * 1000),
        'minimum_cart' => 0,
        'maximum_cart' => null,

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
        'rate' => $faker->numberBetween(10,25),
        'name' => 'Iva',
        'order' => $faker->randomNumber(),
        'external_id' => $faker->randomNumber()
    ];
});