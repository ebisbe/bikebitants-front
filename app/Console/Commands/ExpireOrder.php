<?php

namespace App\Console\Commands;

use App\Business\Checkout\CheckoutOrder;
use App\Business\Services\OrderService;
use App\Order;
use Illuminate\Console\Command;
use Slack;

class ExpireOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire all orders that have not been updated for an hour.';

    protected $orderService;
    /**
     * @var CheckoutOrder
     */
    private $checkoutOrder;


    /**
     * ExpireOrder constructor.
     * @param CheckoutOrder $checkoutOrder
     * @param OrderService $orderService
     */
    public function __construct(CheckoutOrder $checkoutOrder, OrderService $orderService)
    {
        parent::__construct();
        $this->checkoutOrder = $checkoutOrder;
        $this->orderService = $orderService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $orders = $this->orderService->cancelByInactivity();
        $bar = $this->output->createProgressBar($orders->count());

        foreach ($orders as $order) {
            $this->checkoutOrder->setOrder($order);
            $this->checkoutOrder->cancel(trans('checkout.order_cancelled_inactivity'));
            Slack::send($this->formatOrder($order));
            $bar->advance();
        }

        $bar->finish();
    }

    private function formatOrder(Order $order)
    {
        $items = $order->cart->map(function ($item, $key) {
            $key++;
            return "\t$key- {$item->product_id} #{$item->quantity}";
        });

        $billing = [];
        if (isset($order->billing)) {
            $billing = [
                "Buyer info:",
                "\tName: {$order->billing->first_name}  {$order->billing->last_name}",
                "\tEmail: {$order->billing->email}",
                "\tPhone: {$order->billing->phone}"
            ];
        }

        $response = collect([
            "Expiring order {$order->_id}: ",
            "Total amount: {$order->total}€",
            "Items: ",
        ])->merge($items)->merge($billing);
        return $response->implode("\n");
    }
}
