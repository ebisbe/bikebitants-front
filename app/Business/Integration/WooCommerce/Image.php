<?php

namespace App\Business\Integration\WooCommerce;

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
     */
    public function syncImages($images)
    {
        $this->product->images()->each(function ($image) {
            /** @var \App\Image $image */
            $image->delete();
        });

        collect($images)
            ->each(function ($wpImage) {
                $this->sync($wpImage);
            });
    }

    /**
     * @param $wpImage
     * @return \App\Image
     */
    public function sync($wpImage)
    {
        $image = new \App\Image();
        $image->name = $wpImage['name'];
        $image->alt = $wpImage['alt'];
        $image->external_id = $wpImage['id'];
        $image->order = $wpImage['position'];
        $image->filename = self::saveImage($wpImage);

        $this->product->images()->save($image);
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