<?php

namespace App;

use App\Business\Traits\FileHashTrait;

/**
 * Class Image
 * @package App
 *
 * @property string $name
 * @property string $alt
 * @property int $external_id
 * @property int $order
 * @property string $filename
 */
class Image extends \App\Business\Integration\WooCommerce\Models\Image
{
    use FileHashTrait;

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
}
