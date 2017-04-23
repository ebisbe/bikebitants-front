<?php

namespace App\Business\Integration\WooCommerce\Models;

// TODO review this class to follow ApiImporter Pattern
class Image extends ApiImporter
{
    protected $fillable = ['name', 'alt', 'filename', 'external_id', 'order'];

    /**
     * Return predefined image when none is found
     * @return Image
     */
    public static function notFound()
    {
        $name = 'Image not found';
        $file = 'not-found.jpeg';
        return new self([
            'name' => $name,
            'alt' => $name,
            'filename' => $file
        ]);
    }

    public function sync($wpImage)
    {
        $entity['name'] = $wpImage['name'] ?? $wpImage['title'];
        $entity['alt'] = $wpImage['alt'];
        $entity['external_id'] = $wpImage['id'];
        $entity['order'] = $wpImage['position'];
        $entity['filename'] = self::saveImage($wpImage);

        $this->fill($entity);
        return $this;
    }
}
