<?php

namespace App\Business\Services;

use App\Billing;
use App\Country;
use App\Coupon;
use App\Order;
use App\PaymentMethod;
use App\Shipping;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Omnipay;
use Cart;

class OrderService
{
    /** @var Request $request */
    protected $request;
    protected $cache;

    /** @var  User $user */
    protected $user;
    /** @var  Order $order */
    protected $order;
    /** @var  Billing $billing */
    protected $billing;
    /** @var  Shipping $shipping */
    protected $shipping;

    /** @var  String $view */
    protected $view;
    /** @var  array $viewVars */
    protected $viewVars = [];

    protected $response;

    /**
     * OrderService constructor.
     * @param Request $request
     * @param Cache $cache
     * @param Country $country
     * @param PaymentMethod $paymentMethod
     */
    public function __construct(Request $request, Cache $cache, Country $country, PaymentMethod $paymentMethod)
    {
        $this->request = $request;
        $this->cache = $cache;
        $this->country = $country;
        $this->paymentMethod = $paymentMethod;
    }

    public function checkoutOrder($orderId = null)
    {
        $this->getOrder($orderId);
        switch ($this->order->status) {
            case Order::New :
                $this->orderNew();
                break;
            case Order::ToRedirect :
                //$this->pay();
                $this->order->status = Order::Redirected;
                $this->order->save();
                $this->response->redirect();
                break;
            case Order::Redirected :
                $this->confirmPayment();
                break;
            case Order::Confirmed :
                $this->orderConfirmed();
                break;
            case Order::Cancelled :
                $this->setView('checkout.cancel');
                break;
            case Order::Error :
            default:
                $this->orderError();
                break;
        }
    }

    /**
     * @param
     * @return mixed
     */
    public function pay()
    {
        $this->placeOrder();

        Omnipay::setGateway($this->request->input('payment'));
        $gateway = Omnipay::gateway();
        $params = [
            'amount' => number_format($this->order->total, 2), // Add shipping amount
            'currency' => 'EUR',
            'returnUrl' => route('checkout.index'),
            'cancelUrl' => route('shop.cancellation'),
            //'card' => $formData, //$formData = array('number' => '4242424242424242', 'expiryMonth' => '6', 'expiryYear' => '2016', 'cvv' => '123');
        ];
        $this->request->session()->put('payment', $this->request->input('payment'));
        $this->request->session()->put('params', $params);
        $this->request->session()->save();

        $this->response = $gateway->purchase($params)->send();
        $this->validateResponse();
        $this->checkoutOrder();
    }

    public function cancel()
    {
        $this->getOrder();
        $this->order->status = Order::Cancelled;
        $this->order->save();
    }

    /**
     * @param
     */
    private function confirmPayment()
    {
        Omnipay::setGateway($this->request->session()->get('payment'));
        $params = collect($this->request->all())->merge($this->request->session()->get('params', []));
        $this->response = Omnipay::completePurchase($params->toArray())->send();

        $this->validateResponse();
        $this->orderConfirmed();
    }

    private function orderConfirmed()
    {
        $items = $this->getCart()->get();
        $order = $this->order;

        $this->setView('checkout.confirmation');
        $this->setViewVars(compact('items', 'order'));
    }

    /**
     */
    private function validateResponse()
    {
        $this->getOrder();
        if ($this->response->isSuccessful()) {
            $this->order->status = Order::Confirmed;
            Cart::clear();
            Cart::clearCartConditions();
            // TODO send email
        } elseif ($this->response->isRedirect()) {
            $this->order->status = Order::ToRedirect;
        } else {
            $this->order->status = Order::Error;
            $this->order->error_message = $this->response->getMessage();
        }

        $this->order->save();
    }

    /**
     * @param
     */
    private function placeOrder()
    {
        $this->getUser();
        $this->getOrder();

        Coupon::addToCart($this->request->input('coupon', ''));

        $this->order->status = Order::ValidData;
        $this->order->user()->associate($this->user);
        $this->order->billing()->save($this->billing);
        $this->order->shipping()->save($this->shipping);

        $this->order->user_id = $this->user->id;
        $this->order->billing_id = $this->billing->_id;
        $this->order->shipping_id = $this->shipping->_id;
        $this->order->payment_method = $this->request->input('payment');

        $this->order->save();
    }

    /**
     *
     */
    private function orderNew()
    {
        $countries = Cache::remember('countries_list', 5, function () {
            return $this->country->all()->pluck('name', '_id');
        });

        $provinces = Cache::remember('provinces_list', 5, function () {
            return $this->country->first()->provinces->pluck('name', '_id');
        });

        $paymentMethods = Cache::remember('payment_methods', 5, function () {
            return $this->paymentMethod->all();
        });
        $items = Cart::getContent();

        $this->setView('checkout.index');
        $this->setViewVars(compact('countries', 'provinces', 'items', 'paymentMethods'));
    }

    /**
     * Creates a new order for the current session if not exists. Relates all the products
     * from that session to the order.
     */
    private function getOrder($orderId = null)
    {
        if(!is_null($orderId)) {
            $order = Order::where('_id', $orderId)->get();
        } else {
            $order = Order::currentOrder();
        }

        if ($order->isEmpty()) {
            $order = new Order();
            $order->session_id = $this->request->session()->getId();
            $order->status = Order::New;
        } else {
            $order = $order->first();
        }

        if($order->status == Order::New) {

            $order->subtotal = Cart::getSubTotal();
            $order->total = Cart::getTotal();
            $order->total_items = Cart::getTotalQuantity();

            $conditions = Cart::getConditions()->map(function ($item) {
                return [
                    'target' => $item->getTarget(),
                    'value' => $item->getValue(),
                    'name' => $item->getName(),
                    'type' => $item->getType(),
                ];
            })->values()->toArray();

            $order->conditions = $conditions;
            $ids = $order->cart()->get()->map(function ($item) {
                return $item->_id;
            });
            $order->cart()->destroy($ids);
            Cart::getContent()->map(function ($item) use ($order) {
                //dd($item);
                $cart = new \App\Cart();
                $cart->price = $item['price'];
                $cart->quantity = $item['quantity'];
                $cart->total = (int)$item['quantity'] * (int)$item['price'];
                $cart->attributes = $item['attributes']['attributes'];
                $cart->product()->associate($item['attributes']['product']);
                //dd($cart);
                $order->cart()->associate($cart);
            });
        }

        if ($order->save()) {
            //Cart::empty();
            $this->request->session()->set('order', $order->_id);
        }

        $this->order = $order;
    }

    public function orderError()
    {
        $this->setView('checkout.error');
        $message = $this->order->error_message;
        $this->setViewVars(compact('message'));
    }

    /**
     *
     */
    private function getUser()
    {
        //If not logged search user by billing.email
        $user = User::whereEmail($this->request->input('billing.email'))->get();

        if ($user->isEmpty()) {
            $user = new User();
            $user->name = $this->request->input('billing.first_name');
            $user->email = $this->request->input('billing.email');
        } else {
            $user = $user->first();
        }

        $billing = new Billing();
        $billing->first_name = $this->request->billing['first_name'];
        $billing->last_name = $this->request->billing['last_name'];
        $billing->email = $this->request->billing['email'];
        $billing->address = $this->request->billing['address'];
        $billing->city = $this->request->billing['city'];
        $billing->postal_code = $this->request->billing['postal_code'];
        $billing->phone = $this->request->billing['phone'];
        $billing->country = $this->request->billing['country'];
        $billing->province = $this->request->billing['province'];
        $this->billing = $billing;
        $user->billing()->associate($billing);

        $data = $this->request->shipping;
        if ($this->request->check_shipping == 'true') {
            $data = $this->request->billing;
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

        $this->user = $user;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getCart()
    {
        if (empty($this->order)) {
            $this->getOrder();
        }

        return $this->order->cart();
    }

    /**
     * @param $view
     */
    public function setView($view)
    {
        $this->view = $view;
    }

    /**
     * @return String
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * @param array $viewVars
     */
    public function setViewVars($viewVars = [])
    {
        $this->viewVars = $viewVars;
    }

    /**
     * @return array
     */
    public function getViewVars()
    {
        return $this->viewVars;
    }
}