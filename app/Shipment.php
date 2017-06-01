<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
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
 * @property array notify_to
 * @property Order order
 * @property array group
 */
class Shipment extends Model
{
    use Notifiable;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Route notifications for the Slack channel.
     *
     * @return string
     */
    public function routeNotificationForSlack()
    {
        return config('slack.incoming-webhook');
    }

    /**
     */
    public function routeNotificationForMail()
    {
        return 'email overriden by Mailable';
    }
}
