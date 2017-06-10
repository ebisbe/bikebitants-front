<?php

namespace Tests\Feature;

use App\Order;
use App\PaymentMethod;
use App\Product;
use Tests\TestCase;

class CheckoutCallbackTest extends TestCase
{
    protected function tearDown()
    {
        Order::truncate();
        Product::truncate();
        PaymentMethod::truncate();
    }

    public function it_checks_the_callback()
    {
        /** @var Order $order */
        $order = factory(Order::class)->create([
            'token' => 1497013709,
            'status' => Order::REDIRECTED,
            'payment_method_id' => factory(PaymentMethod::class)->lazy([
                'code' => 'PagaMasTarde'
            ]),
        ]);

        $body = '{"event":"charge.created","api_version":1,"account_id":"tk_81dc7853bc3202d251502beb","signature":"19a01eeed010cd22bc06612591a400f893ed766b","data":{"id":"cha_5efd0f0f9ee6ac60c54327d358331bae","amount":6600,"error_code":null,"error_message":null,"order_id":"1497013709","description":"Bikebitants","paid":true,"created_at":"2017-06-09T13:10:46.798Z","status":"paid","commission":7,"amount_to_settle":6593,"discount":0,"metadata":{"phone":null,"address":"Calle Almogavers 165 C2","city":"BARCELONA","province":null,"num_installments":4,"user_email":"enricu@gmail.com"},"closed_at":"2017-06-09T13:10:48.000Z","payment_date":"2017-06-09","charge_type":"whole","card":{"id":"car_683b5e4b9260d3df4fdff10d76356215","bin":"450767","brand":"VISA","type":"debit","category":"CLASICA","country_code":"ES","last4":"0009","expiration_year":2017,"expiration_month":12,"manually_blocked":false,"paypal_order_id":null,"card_type":null,"fingerprint":"M2FlN2RkNWRhNTEwZTJiNjE3M2Y1OTMxMjJiYzA4MDU1MGQ3NDRjYjUwNWE1YzhkZmRjY2UxZDAzMmMwOGYxNw==","entity":{"name":"C.E.C.A.","bank":false,"id":"ent_175c3c3cf61930eea53992a3a8c41b83"}},"refunds":[]}}';
        $response = $this->postJson('/checkout/callback', json_decode($body, true));

        $response->assertJson(['response' => true]);

        $this->assertEquals(Order::CONFIRMED, $order->fresh()->status);
    }
}
