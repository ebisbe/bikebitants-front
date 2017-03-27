<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

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
class Image extends Model
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
}
