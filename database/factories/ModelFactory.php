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

use App\Color;
use App\Product;
use App\Size;
use App\User;

$factory->define(User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Product::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'introduction' => $faker->paragraphs(1, true),
        'description' => $faker->paragraphs(3, true),
        'price' => $faker->numberBetween(3,150)
    ];
});

$factory->define(Color::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->colorName,
    ];
});

$factory->define(Size::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'complementary_text' => $faker->word
    ];
});
