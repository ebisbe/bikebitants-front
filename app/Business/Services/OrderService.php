<?php

namespace App\Business\Services;

use App\Billing;
use App\Cart;
use App\Country;
use App\Order;
use App\PaymentMethod;
use App\Shipping;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use \Omnipay;
use App\Facades\StaticVars;

class OrderService
{
    const orderNew = 1;
    const orderValidData = 2;
    const orderToRedirect = 3;
    const orderRedirected = 4;
    const orderConfirmed = 5;
    const orderCancelled = -1;
    const orderError = -2;

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

    public function checkoutOrder()
    {
        $this->getOrder();
        switch ($this->order->status) {
            case self::orderNew:
                $this->orderNew();
                break;
            case self::orderToRedirect:
                //$this->pay();
                $this->order->status = self::orderRedirected;
                $this->order->save();
                $this->response->redirect();
                break;
            case self::orderRedirected:
                $this->confirmPayment();
                break;
            case self::orderConfirmed:
                $this->orderConfirmed();
                break;
            case self::orderError:
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
            'amount' => number_format($this->order->cart()->sum('subtotal'), 2), // Add shipping amount
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

    public function orderConfirmed()
    {
        $items = $this->getCart()->get();
        $discount = 0;
        $order = $this->order;

        $this->setView('checkout.confirmation');
        $this->setViewVars(compact('items', 'discount', 'order'));
    }
    /**
     */
    private function validateResponse()
    {
        $this->getOrder();
        if ($this->response->isSuccessful()) {
            $this->order->status = self::orderConfirmed;
            // TODO send email
        } elseif ($this->response->isRedirect()) {
            $this->order->status = self::orderToRedirect;
        } else {
            $this->order->status = self::orderError;
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

        $this->order->status = self::orderValidData;
        $this->order->user()->associate($this->user);
        $this->order->billing()->save($this->billing);
        $this->order->shipping()->save($this->shipping);

        $this->order->user_id = $this->user->id;
        $this->order->billing_id = $this->billing->_id;
        $this->order->shipping_id = $this->shipping->_id;
        $this->order->payment_method = $this->request->input('payment');

        $this->order->save();
    }

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
        $discount = 0;
        $products = $this->getCart()->get();

        $this->setView('checkout.index');
        $this->setViewVars(compact('countries', 'provinces', 'products', 'paymentMethods', 'discount'));
    }

    /**
     * Creates a new order for the current session if not exists. Relates all the products
     * from that session to the order.
     */
    private function getOrder()
    {
        $order = Order::whereSessionId($this->request->session()->getId())->get();

        if ($order->isEmpty()) {
            $order = new Order();
            $order->session_id = $this->request->session()->getId();
            $order->status = self::orderNew;
            Cart::all()->map(function($cart) use ($order) {
                $order->cart()->associate($cart);
            });

            if($order->save()) {
                Cart::empty();
            }
        } else {
            $order = $order->first();
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