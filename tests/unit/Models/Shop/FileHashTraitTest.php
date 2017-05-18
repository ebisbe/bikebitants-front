<?php

namespace Tests\Unit\Models\Shop;

use App\Image;
use App\Variation;
use Tests\TestCase;
use Event;

class FileHashTraitTest extends TestCase
{
    public function tearDown()
    {
        Image::truncate();
        Variation::truncate();

    }
    /** @test */
    public function it_shows_image_file_hash()
    {
        $image = factory(Image::class)->create([
            'filename' => 'first_image.jpg'
        ]);

        $this->assertEquals('first_image', $image->file_hash);
    }

    /** @test */
    public function it_shows_variation_file_hash()
    {
        Event::fake();

        $variation = factory(Variation::class)->create([
            '_id' => 'someid',
            'filename' => 'first_image.jpg'
        ]);

        $this->assertEquals('first_image', $variation->file_hash);
    }

}