<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @property array from
 * @property array to
 * @property array new_shipment
 * @property array label
 * @property array colleciton
 * @property array info
 * @property string view_name
 * @property string carrier_service
 * @property string carrier_code
 * @property string order_id
 */
class Shipment extends Model
{
    use Notifiable;
}
