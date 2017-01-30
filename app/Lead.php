<?php

namespace App;

use Moloquent\Eloquent\Model;

/**
 * An Eloquent Model: 'Lead'
 *
 * @property \MongoId $id
 * @property string $email
 * @property string $type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Lead extends Model
{
    protected $fillable = ['email', 'type'];
}
