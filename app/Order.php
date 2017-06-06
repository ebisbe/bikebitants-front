<?php

namespace App;

use App\Business\Repositories\ProductRepository;
use Illuminate\Notifications\Notifiable;
use \Request;

/**
 * Class Order
 * @package App
 *
 * @property int status
 * @property bool print_analytics
 * @property Billing $billing
 * @property Shipping $shipping
 * @property PaymentMethod $payment_method
 * @property integer $external_id
 * @property int total
 * @property array labels
 * @property array shipments
 * @property array response
 *
 */
class Order extends \App\Business\Integration\WooCommerce\Models\Order
{

    use Notifiable;

    const NEW = 1;
    const VALID_DATA = 2;
    const REDIRECTED = 3;
    const CONFIRMED = 4;
    const CANCELLED = -1;
    const UNDEFINED = -2;

    protected $fillable = [
        'user_id',
        'status',
        'payment_method',
        'external_id',
        'print_analytics',
        'user_agent',
        'payment_response'
    ];

    public $attributes = [
        'status' => Order::NEW,
        'print_analytics' => true
    ];

    /**
     *
     */
    public static function boot()
    {
        parent::boot();

        self::creating(function ($order) {
            if ($order->status != Order::NEW) {
                return;
            }

            /** @var Order $order */
            $order->cart()->map(function ($cart) {
                (new ProductRepository())
                    ->findVariationByProduct($cart->product_id, $cart->properties)
                    ->checkStock($cart->quantity);
            });
        });
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
     * @param $entity
     */
    public function sync($entity)
    {
        $entity['status'] = $this->translateStatus($entity['status']);
        $this->fill($entity);

        $billing = new Billing();
        $billing->fill($entity['billing']);
        $this->billing()->associate($billing);

        $shipping = new Shipping();
        $shipping->fill($entity['shipping']);
        $this->shipping()->associate($shipping);

        //cart
        $this->cart->each->delete();
        foreach ($entity['line_items'] as $product) {
            $cart = new Cart();
            $cart->fill([
                "price" => $product['price'],
                "quantity" => $product['quantity'],
                "sku" => $product['sku'],
                "total" => $product['total'] + $product['total_tax'],
                "total_without_iva" => $product['total'],
                "variation_id" => $product['variation_id'],
                //"properties" => $product,
                "product_id" => Product::whereExternalId($product['product_id'])->firstOrFail()->_id
            ]);
            $this->cart()->associate($cart);
        }

        //TODO Search customer
        //TODO find correct shipping method
    }

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsOne
     */
    public function billing()
    {
        return $this->embedsOne(Billing::class);
    }

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsOne
     */
    public function shipping()
    {
        return $this->embedsOne(Shipping::class);
    }

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function cart()
    {
        return $this->embedsMany(Cart::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    /**
     * @return bool
     */
    public static function isCurrentOrderConfirmed()
    {
        $order = self::currentOrder()->get();
        return !$order->isEmpty() && $order->first()->status == self::CONFIRMED ? true : false;
    }

    /**
     * @return Order|null
     */
    public function scopeCurrentOrder($query)
    {
        return $query
            ->where('token', 'exists', true)
            ->where('token', Request::session()->get('order'));
    }

    public function conditionsFilter($condition)
    {
        return collect($this->conditions)
            ->filter(function ($conditions) use ($condition) {
                return $conditions['type'] == $condition;
            })->first();
    }

    public function translateStatus($status)
    {
        $woo_commerce_status = [
            'pending' => self::CONFIRMED,
            'processing' => self::CONFIRMED,
            'on-hold' => self::CONFIRMED,
            'completed' => self::CONFIRMED,
            'cancelled' => self::CANCELLED,
            'refunded',
            'failed' => self::UNDEFINED
        ];

        return $woo_commerce_status[$status] ?? self::UNDEFINED;
    }

    /**
     * @return bool
     */
    public function isShippingToCatalunya(): bool
    {
        return $this->shipping->country == 'ES'
            && in_array(
                strtolower($this->shipping->state),
                array('b', 'l', 'gi', 't')
            );
    }

    /**
     * @return bool
     */
    public function isCashOnDelivery()
    {
        return $this->payment_method->slug == PaymentMethod::CASH_ON_DELIVERY;
    }
}
