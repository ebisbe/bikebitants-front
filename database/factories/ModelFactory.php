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

use App\Attribute;
use App\AttributeValue;
use App\Billing;
use App\Brand;
use App\BrandService;
use App\Category;
use App\Coupon;
use App\Image;
use App\Label;
use App\Lead;
use App\PaymentMethod;
use App\Product;
use App\Review;
use App\Shipping;
use App\User;
use App\Variation;
use Carbon\Carbon;
use \Faker\Generator;
use MongoDB\BSON\UTCDatetime;

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
        '_id' => str_slug($name),
        'name' => $name,
        'generic_name' => 'generic '.$name,
        'slug' => str_slug($name),
        'introduction' => $faker->paragraphs(1, true),
        'description' => $faker->paragraphs(3, true),
        'price' => $faker->numberBetween(3, 150),
        'discount_price' => $faker->numberBetween(3, 150),
        //'image' => $faker->image('/tmp', 150, 150),
        //'discount_init' => $faker->date(),
        //'discount_end' => $faker->date(),
        'tags' => $faker->words(),
        //'video' => 'http://www.youtube.com/embed/M4z90wlwYs8?feature=player_detailpage'
        'meta_title' => $name,
        'meta_description' => $faker->paragraphs(1, true),
        'meta_keywords' => $faker->words(6, true)
    ];
});

$factory->define(Attribute::class, function (Generator $faker) {
    return [
        'name' => $faker->word,
        'order' => $faker->randomNumber()
    ];
});

$factory->define(AttributeValue::class, function (Generator $faker) {
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
        'comment' => $faker->paragraphs(2, true)
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

$factory->define(Brand::class, function (Generator $faker) {
    $name = $faker->words(3, true);
    $files = collect(Storage::files());
    if($files->isEmpty()) {
        $files->push($faker->image(storage_path('app'), 640, 480, null, false));
    }
    return [
        'name' => $name,
        'slug' => str_slug($name) ,
        'description' => $faker->paragraphs(3, true),
        'filename' => $files->random(),
        'featured' => true,
        'meta_title' => $name,
        'meta_description' => $faker->paragraphs(1, true),
        'meta_keywords' => $faker->words(6, true)
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

$factory->define(Variation::class, function (Generator $faker) {
    return [
        '_id' => $faker->slug(),
        'price' => $faker->numberBetween(3, 150),
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

$factory->define(Image::class, function (Generator $faker) {
    $files = collect(Storage::files());
    if($files->isEmpty()) {
        $files->push($faker->image(storage_path('app'), 640, 480, null, false));
    }
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

$factory->define(Category::class, function (Generator $faker) {
    $name = $faker->words(3, true);
    $files = collect(Storage::files());
    if(empty($files)) {
        $files->push($faker->image(storage_path('app'), 640, 480, null, false));
    }
    return [
        'name' => $name,
        'slug' => str_slug($name),
        'filename' => $files->random(),
        'products' => 0,
        'meta_title' => $name,
        'meta_description' => $faker->paragraphs(1, true),
        'meta_keywords' => $faker->words(6, true)
    ];
});

$factory->define(Billing::class, function(Generator $faker) {
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

$factory->define(Shipping::class, function(Generator $faker) {
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

$factory->define(Coupon::class, function(Generator $faker) {
    $discount_value = $faker->numberBetween(10, 30);
    $discount_type = collect([Coupon::DIRECT, Coupon::PERCENTAGE])->random();
    return [
        'name' => str_slug($faker->words(3, true)),
        'type' => 'coupon',
        'target' => 'subtotal',
        'value' => "-{$discount_value}{$discount_type}",

        'discount_value' => $discount_value,
        'discount_type' => $discount_type,
        'limit_usage_by_coupon' => 3,
        'limit_usage_by_user' => 1,
        'expiry_date' => New UTCDatetime(Carbon::now()->addDays(4)->timestamp * 1000) ,
        'minimum_cart' => 0,
        'maximum_cart' => null,
        'single_use' => true,
        'emails' => [ $faker->email, $faker->email, $faker->email ]
    ];
});