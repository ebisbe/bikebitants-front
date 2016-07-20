<?php

namespace App\Business\Services;

use App\Billing;
use App\Cart;
use App\Order;
use App\Shipping;
use App\User;
use Illuminate\Http\Request;
use \Omnipay;
use App\Facades\StaticVars;


class OrderService
{
    /** @var  User $user */
    protected $user;
    /** @var  Order $order */
    protected $order;
    /** @var  Billing $billing */
    protected $billing;
    /** @var  Shipping $shipping */
    protected $shipping;

    /**
     * Creates a new order for the current session if not exists. Relates all the products
     * from that session to the order.
     * @param Request $request
     * @return Order
     */
    public function getOrder(Request $request)
    {
        $order = Order::whereSessionId($request->session()->getId())->get();

        if ($order->isEmpty()) {
            $order = new Order();
            $order->session_id = $request->session()->getId();
            $order->status = StaticVars::orderNew();
            if (!$order->save()) {
                // throw exception
            }
        } else {
            $order = $order->first();
        }
        $cart = Cart::all();
        $order->cart()->saveMany($cart);
        $this->order = $order;
        return $order;
    }

    /**
     * @param Request $request
     */
    public function placeOrder(Request $request)
    {
        $this->user = $this->getUser($request);
        $this->order = $this->getOrder($request);
        $this->order->status = StaticVars::orderValidData();
        $this->order->user()->associate($this->user);
        $this->order->billing()->save($this->billing);
        $this->order->shipping()->save($this->shipping);

        $this->order->user_id = $this->user->id;
        $this->order->billing_id = $this->billing->_id;
        $this->order->shipping_id = $this->shipping->_id;
        $this->order->payment_method = $request->input('payment');

        $this->order->save();
    }

    /**
     * @param Request $request
     * @param User $user
     * @return User|\Illuminate\Database\Eloquent\Model|null|static
     */
    private function getUser(Request $request)
    {
        //If not logged search user by billing.email
        $user = User::whereEmail($request->input('billing.email'))->get();

        if($user->isEmpty()) {
            $user = new User();
            $user->name = $request->input('billing.first_name');
            $user->email = $request->input('billing.email');
        } else {
            $user = $user->first();
        }

        $billing = new Billing();
        $billing->first_name = $request->billing['first_name'];
        $billing->last_name = $request->billing['last_name'];
        $billing->email = $request->billing['email'];
        $billing->address = $request->billing['address'];
        $billing->city = $request->billing['city'];
        $billing->postal_code = $request->billing['postal_code'];
        $billing->phone = $request->billing['phone'];
        $billing->country = $request->billing['country'];
        $billing->province = $request->billing['province'];
        $this->billing = $billing;
        $user->billing()->associate($billing);

        $data = $request->shipping;
        if ($request->check_shipping == 'true') {
            $data = $request->billing;
        }
        $shipping = new Shipping();
        $shipping->first_name = $data['first_name'];
        $shipping->last_name = $data['last_name'];
        $shipping->email = $data['email'];
        $shipping->address = $data['address'];
        $shipping->city = $data['city'];
        $shipping->postal_code = $data['postal_code'];
        $shipping->phone = $data['phone'];
        $shipping->country = $data['country'];
        $shipping->province = $data['province'];
        $this->shipping = $shipping;
        $user->shipping()->associate($shipping);

        $user->save();

        return $user;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getCart()
    {
        if (empty($this->order)) {
            //throw exception
        }

        return $this->order->cart();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function pay(Request $request)
    {
        $this->placeOrder($request);

        Omnipay::setGateway($request->input('payment'));
        $gateway = Omnipay::gateway();
        $params = [
            'amount' => number_format($this->order->cart()->sum('subtotal'), 2), // Add shipping amount
            'currency' => 'EUR',
            'returnUrl' => route('shop.confirmation'),
            'cancelUrl' => route('shop.cancellation'),
            //'card' => $formData, //$formData = array('number' => '4242424242424242', 'expiryMonth' => '6', 'expiryYear' => '2016', 'cvv' => '123');
        ];
        $request->session()->put('payment', $request->input('payment'));
        $request->session()->put('params', $params);
        $request->session()->save();

        $response = $gateway->purchase($params)->send();
        $response = $this->validateResponse($response);
    }

    /**
     * @param Request $request
     */
    public function confirmPayment(Request $request)
    {
        Omnipay::setGateway($request->session()->get('payment'));
        $params = collect($request->all())->merge($request->session()->get('params', []));
        $response = Omnipay::completePurchase($params->toArray())->send();

        $this->validateResponse($response,$request);

    }

    /**
     * @param $response
     * @return mixed
     * @throws \Exception
     */
    private function validateResponse($response, Request $request)
    {
        if ($response->isSuccessful()) {
            // payment was successful: update database
            $this->getOrder($request);

            $this->order->status = StaticVars::orderConfirmed();
            if(!$this->order->save()) {
                //throw exception
            }
            return $response;
        } elseif ($response->isRedirect()) {
            // redirect to offsite payment gateway
            $response->redirect();
        } else {
            // payment failed: display message to customer
            throw new \Exception($response->getMessage(), 401);
        }
    }
}