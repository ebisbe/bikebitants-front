<?php

namespace App;

use Moloquent\Eloquent\Model;

/**
 * Class Image
 * @package App
 *
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
        $file = 'not-found.jpg';
        return new self([
            'name' => $name,
            'alt' => $name,
            'filename' => $file
        ]);
    }
}
