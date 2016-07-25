<?php

namespace App;

use App\Business\MongoEloquentModel as Model;
use MongoDB\BSON\UTCDatetime;

/**
 * Class Coupon
 * @package App
 *
 * @property UTCDatetime expiry_date
 * @property integer minimum_cart
 * @property integer|null maximum_cart
 */
class Coupon extends Model
{
    const PERCENTAGE = '%';
    const DIRECT = '&euro;';
}
