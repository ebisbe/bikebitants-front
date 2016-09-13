<?php

namespace App;

use App\Business\MongoEloquentModel as Model;

/**
 * Class Image
 * @package App
 *
 * @property string $filename
 */
class Image extends Model
{
    protected $fillable = ['name', 'alt', 'filename'];
}
