<?php

namespace App\Business\Services;

use App\Billing;
use App\Business\Status\CancelledOrder;
use App\Business\Status\Status;
use App\Business\Status\UndefinedOrder;
use App\Business\Repositories\ProductRepository;
use App\Events\CancelOrder;
use App\Events\ConfirmedOrder;
use App\Events\NewOrder;
use App\Exceptions\OutOfStockException;
use App\Order;
use App\PaymentMethod;
use App\Shipping;
use App\Customer;
use Carbon\Carbon;
use Darryldecode\Cart\ItemCollection;
use Illuminate\Support\Arr;
use Omnipay;
use Cart;
use Event;
use Symfony\Component\HttpFoundation\Request;

class OrderService
{
    /** @var  Order $order */
    protected $order;

    /** @var  String $view */
    protected $view;
    /** @var  array $viewVars */
    protected $viewVars = [];

    protected $response;

    protected $payment_type;
    protected $coupon;
    protected $session_id;
    protected $form_params;

    /** Repositories */
    protected $couponService;
    protected $productRepository;

    /**
     * OrderService constructor.
     * @param CouponService $couponService
     * @param ProductRepository $productRepository
     */
    public function __construct(CouponService $couponService, ProductRepository $productRepository)
    {
        $this->couponService = $couponService;
        $this->productRepository = $productRepository;
    }

    /**
     * @param bool $avoidLoop
     * @return Status
     */
    public function checkoutOrder($avoidLoop = false) :Status
    {
        $this->getOrder();
        switch (true) {
            case $this->order->status == Order::New :
                return \App::make('NewOrder');
                break;
            case $this->order->status == Order::ToRedirect :
                $this->order->status = Order::Redirected;
                $this->order->save();
                //Event::fire('order.redirected', [$this->order]);
                $this->response->redirect();
                break;
            case $this->order->status == Order::Redirected && !$avoidLoop :
                return $this->confirmPayment();
                break;
            case $this->order->status == Order::Confirmed :
                return new \App\Business\Status\ConfirmedOrder($this->order);
                break;
            case $this->order->status == Order::Cancelled :
                return new CancelledOrder();
                break;
            case $this->order->status == Order::Undefined :
            default:
                return new UndefinedOrder($this->order);
                break;
        }
    }

    /**
     * @return Status
     */
    private function confirmPayment()
    {
        Omnipay::setGateway($this->getPaymentType()->code);
        $gateway = Omnipay::gateway();
        if ($gateway->supportsCompleteAuthorize()) {
            $this->response = Omnipay::completePurchase($this->getPurchaseParams())->send();
            $this->validateResponse();
        }

        return $this->checkoutOrder(true);
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
        Omnipay::setGateway($this->getPaymentType()->code);
        $request = Request::createFromGlobals();
        $this->response = Omnipay::checkCallbackResponse($request, true);
        $params = Omnipay::decodeCallbackResponse($request);

        $order = Order::whereToken((int)$params['Ds_Order'])->first();
        $this->setOrder($order);
        $this->validateResponse();
    }

    /**
     * @param
     * @return Status
     */
    public function pay()
    {
        $this->placeOrder();

        Omnipay::setGateway($this->getPaymentType()->code);
        $gateway = Omnipay::gateway();

        $this->response = $gateway->purchase($this->getPurchaseParams())->send();
        $this->validateResponse();
        return $this->checkoutOrder();
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
            $this->order->status = Order::Undefined;
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
        $this->getOrder();

        $this->order->status = Order::ValidData;

        $customer = $this->getCustomer();
        $this->order->customer()->associate($customer);
        $this->order->billing()->associate($customer->billing);
        $this->order->shipping()->associate($customer->shipping);

        $this->order->payment_method()->associate($this->getPaymentType());

        $this->order->customer_id = $customer->id;

        $this->order->save();
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
            $order = $this->updateOrder($order);

            if($order->status == Order::New) {
                Event::fire(new NewOrder($order));
            }
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
    protected function updateOrder(Order $order) : Order
    {
        if ($order->status == Order::New) {

            $order->subtotal = Cart::getSubTotal();
            $order->total = Cart::getTotal();
            $order->total_items = Cart::getTotalQuantity();
            $order->conditions = $this->updateOrderConditions();

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
                $cart->product_id = $item['attributes']['_id'];
                $product = $this->productRepository->find($item['attributes']['_id']);
                $cart->product()->associate($product);
                $order->cart()->associate($cart);
            });

            try {
                $order->save();
            } catch (OutOfStockException $exception) {
                $order->status = Order::Undefined;
                $order->message = $exception->getMessage();
            }
        }
        return $order;
    }

    public function updateOrderConditions()
    {
        return Cart::getConditions()
            ->map(function ($item) {
                return [
                    'target' => $item->getTarget(),
                    'value' => $item->getValue(),
                    'name' => $item->getName(),
                    'type' => $item->getType(),
                ];
            })
            ->values()
            ->toArray();
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
    private function getCustomer()
    {
        //If not logged search customer by billing.email
        $customer = Customer::whereEmail($this->getFormParams('billing.email'))->get();

        if ($customer->isEmpty()) {
            $customer = new Customer();
            $customer->fill($this->getFormParams('billing'));
        } else {
            $customer = $customer->first();
        }

        $billing = new Billing();
        $billing->fill($this->getFormParams('billing'));
        $customer->billing()->associate($billing);

        $data = $this->getFormParams('shipping');
        if ($this->getFormParams('check_shipping') == 'true') {
            $data = $this->getFormParams('billing');
        }
        $shipping = new Shipping();
        $shipping->fill($data);
        $customer->shipping()->associate($shipping);

        $customer->save();

        return $customer;
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

    public function setPaymentType(string $paymentType)
    {
        $this->payment_type = PaymentMethod::whereSlug($paymentType)->first();
    }

    /**
     * @return PaymentMethod
     */
    public function getPaymentType()
    {
        return $this->payment_type;
    }

    public function setCoupon(string $coupon)
    {
        if(empty($coupon)) {
            return false;
        }

        $this->couponService->addCoupon($coupon);
        $this->order = $this->updateOrder($this->order);
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