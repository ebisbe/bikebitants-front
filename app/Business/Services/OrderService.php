<?php

namespace App\Business\Services;

use App\Billing;
use App\Country;
use App\Coupon;
use App\Events\CancelOrder;
use App\Events\ConfirmedOrder;
use App\Events\NewOrder;
use App\Order;
use App\PaymentMethod;
use App\Shipping;
use App\Buyer;
use Carbon\Carbon;
use Darryldecode\Cart\ItemCollection;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Omnipay;
use Cart;
use Event;
use Symfony\Component\HttpFoundation\Request;

class OrderService
{
    use DispatchesJobs;

    protected $cache;

    /** @var  Buyer $buyer */
    protected $buyer;
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

    protected $country;
    protected $paymentMethod;

    protected $payment_type;
    protected $coupon;
    protected $session_id;
    protected $form_params;

    /**
     * OrderService constructor.
     * @param Cache $cache
     * @param Country $country
     * @param PaymentMethod $paymentMethod
     */
    public function __construct(Cache $cache, Country $country, PaymentMethod $paymentMethod)
    {
        $this->cache = $cache;
        $this->country = $country;
        $this->paymentMethod = $paymentMethod;
    }

    public function checkoutOrder($avoidLoop = false)
    {
        $this->getOrder();
        switch ($this->order->status) {
            case Order::New :
                $this->orderNew();
                break;
            case Order::ToRedirect :
                $this->order->status = Order::Redirected;
                $this->order->save();
                //Event::fire('order.redirected', [$this->order]);
                $this->response->redirect();
                break;
            case Order::Redirected && !$avoidLoop :
                $this->confirmPayment();
                break;
            case Order::Confirmed :
                $this->orderConfirmed();
                break;
            case Order::Cancelled :
                $this->orderCancelled();
                break;
            case Order::Error :
            default:
                $this->orderError();
                break;
        }
    }

    /**
     * @param
     */
    private function confirmPayment()
    {
        Omnipay::setGateway($this->getPaymentType());
        $gateway = Omnipay::gateway();
        if ($gateway->supportsCompleteAuthorize()) {
            $this->response = Omnipay::completePurchase($this->getPurchaseParams())->send();
            $this->validateResponse();
        }

        $this->checkoutOrder(true);
    }

    /**
     * Redsys callback based on symphony components. All params are received as string. Type cast to INT if needed.
     * Array
     * (
     * [Ds_Date] => 15/11/2016
     * [Ds_Hour] => 13:33
     * [Ds_SecurePayment] => 1
     * [Ds_Card_Country] => 724
     * [Ds_Amount] => 11990
     * [Ds_Currency] => 978
     * [Ds_Order] => 1479213208
     * [Ds_MerchantCode] => 336022801
     * [Ds_Terminal] => 001
     * [Ds_Response] => 0000
     * [Ds_MerchantData] =>
     * [Ds_TransactionType] => 0
     * [Ds_ConsumerLanguage] => 1
     * [Ds_AuthorisationCode] => 622880
     * )
     */
    public function checkoutCallback()
    {
        Omnipay::setGateway($this->getPaymentType());
        $request = Request::createFromGlobals();
        $this->response = Omnipay::checkCallbackResponse($request, true);
        $params = Omnipay::decodeCallbackResponse($request);

        $order = Order::whereToken((int)$params['Ds_Order'])->first();
        $this->setOrder($order);
        $this->validateResponse();
    }

    /**
     * @param
     * @return void
     */
    public function pay()
    {
        $this->placeOrder();

        Omnipay::setGateway($this->getPaymentType());
        $gateway = Omnipay::gateway();

        $this->response = $gateway->purchase($this->getPurchaseParams())->send();
        $this->validateResponse();
        $this->checkoutOrder();
    }

    /**
     * Cancel the order
     */
    public function cancel()
    {
        $this->getOrder();
        if ($this->order->status > Order::Cancelled) {
            $this->order->status = Order::Cancelled;
            if ($this->order->save()) {
                Event::fire(new CancelOrder($this->order));
                return true;
            } else {
                // TODO throw some shit
            }
        } else {
            //TODO throw OrderServiceException with order already Cancelled
        }
    }

    private function orderConfirmed()
    {
        $items = $this->getCart();
        $order = $this->order;

        Cart::clear();
        Cart::clearCartConditions();

        $this->setView('checkout.confirmation');
        $this->setViewVars(compact('items', 'order'));
    }

    private function orderCancelled()
    {
        $message = $this->order->error_message ? $this->order->error_message : trans('checkout.order_cancelled');

        $this->setView('checkout.cancel');
        $this->setViewVars(compact('message'));
    }

    /**
     * @param null $orderId
     */
    private function validateResponse()
    {
        $this->getOrder();
        if ($this->response->isSuccessful()) {
            $this->order->status = Order::Confirmed;
            $this->order->save();
            // TODO send email
            Event::fire(new ConfirmedOrder($this->order));
        } elseif ($this->response->isRedirect()) {
            $this->order->status = Order::ToRedirect;
            $this->order->save();
            //Event::fire('order.to_redirect', [$this->order]);
        } else {
            $this->order->status = Order::Error;
            $this->order->error_message = $this->response->getMessage();
            $this->order->save();
            //Event::fire('order.error', [$this->order]);
        }
    }

    /**
     * @param
     */
    private function placeOrder()
    {
        $this->getBuyer();
        $this->getOrder();

        Coupon::addToCart($this->getCoupon());

        $this->order->status = Order::ValidData;
        $this->order->buyer()->associate($this->buyer);
        $this->order->billing()->save($this->billing);
        $this->order->shipping()->save($this->shipping);

        $paymentMethod = PaymentMethod::whereCode($this->getPaymentType())->first();
        $this->order->payment_method()->associate($paymentMethod);

        $this->order->buyer_id = $this->buyer->id;

        $this->order->save();
    }

    /**
     * TODO Create Repositories
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
    private function getOrder()
    {
        if (!$this->order instanceof Order) {
            /** @var Order $order */
            $order = new Order();
            $order->token = Carbon::now()->timestamp;
            $order->session_id = $this->getSessionId();
            $this->updateOrder($order);

            Event::fire(new NewOrder($order));
            $this->order = $order;
        }
    }

    /**
     * @param Order $order
     */
    public function setOrder(Order $order)
    {
        $this->order = $this->updateOrder($order);
    }

    /**
     * @param Order $order
     * @return Order
     */
    protected function updateOrder(Order $order)
    {
        if ($order->status == Order::New) {

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
                /** @var ItemCollection $item */
                $cart = new \App\Cart();
                $cart->price = $item->getPriceWithConditions();
                $cart->quantity = $item['quantity'];
                $cart->total = $item->getPriceSumWithConditions();
                $cart->properties = $item['attributes']['properties'];
                $cart->variation_id = $item['attributes']['variation_id'];
                $cart->product_id = $item['attributes']['product']->external_id;
                $cart->product()->associate($item['attributes']['product']);
                $order->cart()->associate($cart);
            });

            $order->save();
        }
        return $order;
    }

    public function orderError()
    {
        $this->setView('checkout.error');
        $message = $this->order->error_message;
        $this->setViewVars(compact('message'));
    }

    protected function getPurchaseParams()
    {
        return [
            'amount' => $this->order->total,
            'multiply' => true,
            'returnUrl' => route('checkout.index'),
            'cancelUrl' => route('shop.cancellation'),
            'transactionId' => $this->order->token,
            'description' => env('OMNIPAY_DESCRIPTION'),
            'testMode' => true,
            //'card' => $formData, //$formData = array('number' => '4242424242424242', 'expiryMonth' => '6', 'expiryYear' => '2016', 'cvv' => '123');
        ];
    }

    /**
     *
     */
    private function getBuyer()
    {
        //If not logged search buyer by billing.email
        $buyer = Buyer::whereEmail($this->getFormParams('billing.email'))->get();

        if ($buyer->isEmpty()) {
            $buyer = new Buyer();
            $buyer->fill($this->getFormParams('billing'));
        } else {
            $buyer = $buyer->first();
        }

        $billing = new Billing();
        $billing->fill($this->getFormParams('billing'));
        $this->billing = $billing;
        $buyer->billing()->associate($billing);

        $data = $this->getFormParams('shipping');
        if ($this->getFormParams('check_shipping') == 'true') {
            $data = $this->getFormParams('billing');
        }
        $shipping = new Shipping();
        $shipping->fill($data);
        $this->shipping = $shipping;
        $buyer->shipping()->associate($shipping);

        $buyer->save();

        $this->buyer = $buyer;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getCart()
    {
        if (empty($this->order)) {
            $this->getOrder();
        }

        return $this->order->cart;
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

    public function setPaymentType($paymentType)
    {
        $this->payment_type = $paymentType;
    }

    public function getPaymentType()
    {
        return $this->payment_type;
    }

    public function setCoupon($coupon)
    {
        $this->coupon = $coupon;
    }

    public function getCoupon()
    {
        return $this->coupon;
    }

    public function setSessionId($session_id)
    {
        $this->session_id = $session_id;
    }

    public function getSessionId()
    {
        return $this->session_id;
    }

    public function setFormParams($form_params)
    {
        $this->form_params = $form_params;
    }

    public function getFormParams($route = null)
    {
        return Arr::get($this->form_params, $route);
    }

    public function getToken()
    {
        return $this->order->token;
    }
}