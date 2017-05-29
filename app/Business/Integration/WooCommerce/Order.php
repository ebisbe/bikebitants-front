<?php

namespace App\Business\Integration\WooCommerce;

use App\Coupon;
use App\Events\OrderPushed as OrderPushedEvent;
use App\Notifications\OrderPushed as OrderPushedNotification;
use App\Exceptions\OrderNotSavedException;
use App\Shipping;
use App\Order as AppOrder;
use Event;

class Order
{
    /**
     * @param AppOrder $order
     * @return AppOrder
     * @throws OrderNotSavedException
     */
    public function create(AppOrder $order): AppOrder
    {

        $data = $this->postData($order);
        $response = \Woocommerce::post('orders', $data);

        $order->external_id = $response['id'];
        $order->response = $response;

        if (!$order->save()) {
            throw new OrderNotSavedException($order->_id, $response['id']);
        } else {
            Event::fire(new OrderPushedEvent($order->fresh()));
            $order->notify(new OrderPushedNotification($order));
        }

        return $order;
    }

    /**
     * @param AppOrder $order
     * @return array
     */
    protected function couponLines(AppOrder $order): array
    {
        $coupon = [];
        $couponCondition = $order->conditionsFilter(Coupon::CART_CONDITION_TYPE);
        if (!empty($couponCondition)) {
            $couponRaw = Coupon::whereName($couponCondition['name'])->first();

            $coupon = [
                [
                    'code' => $couponRaw->name,
                    'discount' => 0
                ]
            ];
        }
        return $coupon;
    }

    /**
     * @param AppOrder $order
     * @return array
     */
    protected function itemLines(AppOrder $order)
    {
        return $order->cart->map(function ($cart) {
            $item = [];
            $item['product_id'] = $cart->product_id;
            $item['total'] = $cart->total_without_iva;
            $item['quantity'] = $cart->quantity;
            if (!empty($cart->product->properties)) {
                $item['variation_id'] = $cart->variation_id;
            }
            return $item;
        })->toArray();
    }

    /**
     * @param AppOrder $order
     * @return array
     */
    protected function postData(AppOrder $order): array
    {
        $shipping = $order->conditionsFilter(Shipping::CART_CONDITION_TYPE);

        return [
            'payment_method' => $order->payment_method->name,
            'payment_method_title' => $order->payment_method->name,
            'set_paid' => $order->payment_method->set_paid,
            'billing' => [
                'first_name' => $order->billing->first_name,
                'last_name' => $order->billing->last_name,
                'address_1' => $order->billing->address_1,
                'address_2' => $order->billing->address_2,
                'city' => $order->billing->city,
                'state' => $order->billing->state,
                'postcode' => $order->billing->postcode,
                'country' => $order->billing->country,
                'email' => $order->billing->email,
                'phone' => $order->billing->phone,
            ],
            'shipping' => [
                'first_name' => $order->shipping->first_name,
                'last_name' => $order->shipping->last_name,
                'address_1' => $order->shipping->address_1,
                'address_2' => $order->shipping->address_2,
                'city' => $order->shipping->city,
                'state' => $order->shipping->state,
                'postcode' => $order->shipping->postcode,
                'country' => $order->shipping->country,
            ],
            'line_items' => $this->itemLines($order),
            'shipping_lines' => [
                [
                    'method_id' => 'flat_rate',
                    'method_title' => $shipping['name'],
                    'total' => $shipping['value'] / 1.21,
                ]
            ],
            "coupon_lines" => $this->couponLines($order)
        ];
    }
}
