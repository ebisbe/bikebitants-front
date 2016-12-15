<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * Class Image
 * @package App
 *
 * @property string $filename
 */
class Image extends Model
{
    protected $fillable = ['name', 'alt', 'filename', 'external_id', 'order'];
}
