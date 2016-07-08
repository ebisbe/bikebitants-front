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
use App\Brand;
use App\BrandService;
use App\Image;
use App\Label;
use App\Lead;
use App\PaymentMethod;
use App\Product;
use App\Review;
use App\User;
use App\Variation;

$factory->define(User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Product::class, function (Faker\Generator $faker) {
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
    ];
});

$factory->define(Attribute::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'order' => $faker->randomNumber()
    ];
});

$factory->define(AttributeValue::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'sku' => $faker->word,
        'complementary_text' => $faker->word
    ];
});

$factory->define(Review::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'comment' => $faker->paragraphs(2, true)
    ];
});

$factory->define(Label::class, function (Faker\Generator $faker) {
    $type = ['Default', 'Primary', 'Success', 'Info', 'Warning', 'Danger'];
    $chosen = $faker->randomElement($type);

    return [
        'name' => $chosen,
        'css' => strtolower($chosen)
    ];
});

$factory->define(Brand::class, function (Faker\Generator $faker) {
    $name = $faker->words(3, true);
    return [
        'name' => $name,
        'slug' => str_slug($name) ,
        'description' => $faker->paragraphs(3, true),
        'image' => ''
    ];
});

$factory->define(BrandService::class, function (Faker\Generator $faker) {
    $position = ['left', 'right'];
    return [
        'title' => $faker->words(3, true),
        'description' => $faker->paragraphs(3, true),
        'image' => '',
        'position' => $faker->randomElement($position)
    ];
});

$factory->define(Variation::class, function (Faker\Generator $faker) {
    return [
        '_id' => $faker->slug(),
        'price' => $faker->numberBetween(3, 150),
    ];
});

$factory->define(PaymentMethod::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->words(3, true),
        'short_description' => $faker->paragraphs(1, true),
        'description' => $faker->paragraphs(3, true),
        'code' => $faker->slug(2),
    ];
});

$factory->define(Image::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->words(3, true),
        'alt' => $faker->paragraphs(1, true),
        'path' => $faker->image(storage_path('app'), 1500, 1500, null, false),
    ];
});

$factory->define(Lead::class, function (Faker\Generator $faker) {
    return [
        'email' => $faker->email,
        'type' => $faker->words(1, true)
    ];
});