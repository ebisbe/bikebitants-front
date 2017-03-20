<?php

namespace App\Business\Integration\Wordpress;

use App\Product;
use Storage;

class Image
{
    public static $WP_FILE = 'wp_files';
    /**
     * @var Product
     */
    private $product;

    /**
     * Image constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Import Images
     * @param $images
     * @param $product
     */
    public function syncImages($images)
    {
        $ids = collect($images)
            ->map(function ($wpImage) {
                return $this->sync($wpImage, $this->product);
            })
            ->pluck('external_id')
            ->toArray();

        //Find deleted images
        $imagesToDelete = $this->product
            ->images()
            ->filter(function ($image) use ($ids) {
                return !in_array($image['external_id'], $ids);
            });
        //Delete attributes
        $imagesToDelete->each(function ($attribute) {
            $this->product->images()->destroy($attribute);
        });
    }

    /**
     * @param $wpImage
     * @return Image
     */
    public function sync($wpImage)
    {
        $image = $this->product
            ->images()
            ->filter(function ($image) use ($wpImage) {
                return $image->external_id == $wpImage['id'];
            })
            ->first();

        $new = false;
        if (empty($image)) {
            $image = new \App\Image();
            $new = true;
        }
        $image->name = $wpImage['name'];
        $image->alt = $wpImage['alt'];
        $image->external_id = $wpImage['id'];
        $image->order = $wpImage['position'];
        $image->filename = self::saveImage($wpImage);

        if ($new) {
            $this->product->images()->save($image);
        } else {
            $image->save();
        }
        return $image;
    }

    /**
     * @param $image
     * @return string
     */
    public static function saveImage($image)
    {
        try {
            if (!empty($image['src'])) {
                list($url, $name) = self::encodeSrc($image['src']);
                if (!Storage::exists(static::$WP_FILE . '/' . $name)) {
                    Storage::put(static::$WP_FILE . '/' . $name, file_get_contents($url . $name));
                }
                return $name;
            }
        } catch (\ErrorException $e) {
            return '';
        }
    }

    /**
     * @param $source
     * @return array
     */
    public static function encodeSrc($source)
    {
        $name = basename($source);

        return [str_replace($name, '', $source), urlencode($name)];
    }

}