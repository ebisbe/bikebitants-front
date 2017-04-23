<?php

namespace App\Business\Checkout;

use App\Billing;
use App\Business\Checkout\Status\CancelledOrder;
use App\Business\Checkout\Status\Status;
use App\Business\Checkout\Status\UndefinedOrder;
use App\Business\Checkout\Status\ConfirmedOrder;
use App\Business\Repositories\ProductRepository;
use App\Business\Checkout\Events\Cancel;
use App\Business\Checkout\Events\Confirm;
use App\Business\Checkout\Events\Create;
use App\Business\Services\CouponService;
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

class CheckoutOrder
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
     * @return Status
     */
    public function checkoutOrder(): Status
    {
        $this->getOrder();
        switch ($this->order->status) {
            case Order::NEW:
                return \App::make('NewOrder');
                break;
            case Order::REDIRECTED:
                return $this->confirmPayment();
                break;
            case Order::CONFIRMED:
                return new ConfirmedOrder($this->order);
                break;
            case Order::CANCELLED:
                return new CancelledOrder($this->order);
                break;
            case Order::UNDEFINED:
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
        $this->response = Omnipay::completePurchase($this->getPurchaseParams())->send();
        $this->validateResponse();

        return $this->checkoutOrder();
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
    }

    /**
     * Cancel the order
     */
    public function cancel($message)
    {
        $this->getOrder();
        if ($this->order->status > Order::CANCELLED) {
            $this->order->status = Order::CANCELLED;
            $this->order->error_message = $message;
            if ($this->order->save()) {
                Event::fire(new Cancel($this->order));
                return true;
            } else {
                // TODO throw some error
            }
        } else {
            //TODO throw OrderServiceException with order already Cancelled
        }
    }

    private function validateResponse()
    {
        $this->getOrder();
        if ($this->response->isSuccessful()) {
            $this->order->status = Order::CONFIRMED;
            $this->order->save();
            // TODO send email
            Event::fire(new Confirm($this->order));
        } elseif ($this->response->isRedirect()) {
            $this->order->status = Order::REDIRECTED;
            $this->order->save();
            $this->response->redirect();
        } else {
            $this->order->status = Order::UNDEFINED;
            $this->order->error_message = $this->response->getMessage();
            $this->order->save();
            //Event::fire('order.error', [$this->order]);
        }
    }

    private function placeOrder()
    {
        $this->getOrder();

        $this->order->status = Order::VALID_DATA;

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

            if ($order->status == Order::NEW) {
                Event::fire(new Create($order));
            }
            $this->order = $order;
        }
    }

    /**
     * @param Order $order
     */
    public function setOrder(Order $order)
    {
        $this->order = $order;
    }

    /**
     * @param Order $order
     */
    public function setOrderAndUpdate(Order $order)
    {
        $this->order = $this->updateOrder($order);
    }

    /**
     * @param Order $order
     * @return Order
     */
    protected function updateOrder(Order $order): Order
    {
        if ($order->status == Order::NEW) {
            $order->subtotal = Cart::getSubTotalWithoutConditions();
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
                $cart->total_without_iva = $item->getPriceSumWithConditions() / 1.21;
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
                $order->status = Order::UNDEFINED;
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

    protected function getPurchaseParams()
    {
        return [
            'amount' => $this->order->total,
            'multiply' => true,
            'returnUrl' => route('checkout.index'),
            'cancelUrl' => route('shop.cancellation'),
            'transactionId' => $this->order->token,
            'description' => config('app.name'),
            'testMode' => config('app.env') == 'production' ? false : true,
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
     * @param string $paymentType
     */
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

    /**
     * @param $coupon
     * @return bool
     */
    public function setCoupon($coupon)
    {
        if (empty($coupon)) {
            return false;
        }

        $this->couponService->addCoupon($coupon);
        $this->order = $this->updateOrder($this->order);

        return true;
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
