<?php

use App\Color;
use App\Product;
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
        // $this->call(UsersTableSeeder::class);

        $product = factory(Product::class)->create();

        $product->colors()->save(factory(Color::class)->make());
        $product->colors()->save(factory(Color::class)->make());
        $product->colors()->save(factory(Color::class)->make());

        $product->sizes()->save(factory(Size::class)->make(
            [
                'name' => 'L',
                'complementary_text' => '60-62cm'
            ]
        ));
        $product->sizes()->save(factory(Size::class)->make(
            [
                'name' => 'M',
                'complementary_text' => '57-59cm'
            ]
        ));
        $product->sizes()->save(factory(Size::class)->make(
            [
                'name' => 'S',
                'complementary_text' => '54-56cm'
            ]
        ));
    }
}
