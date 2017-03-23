<?php

namespace App\Console\Commands;

use App\Business\Checkout\CheckoutOrder;
use App\Business\Services\OrderService;
use Illuminate\Console\Command;

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
     * @var CheckoutOrderService
     */
    private $checkoutOrderService;


    /**
     * ExpireOrder constructor.
     * @param CheckoutOrder $checkoutOrderService
     * @param OrderService $orderService
     */
    public function __construct(CheckoutOrder $checkoutOrderService, OrderService $orderService)
    {
        parent::__construct();
        $this->checkoutOrderService = $checkoutOrderService;
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
            $this->checkoutOrderService->setOrder($order);
            $this->checkoutOrderService->cancel(trans('checkout.order_cancelled_inactivity'));
            $bar->advance();
        }

        $bar->finish();
    }
}
