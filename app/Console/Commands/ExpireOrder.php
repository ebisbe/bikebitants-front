<?php

namespace App\Console\Commands;

use App\Business\Services\CheckoutOrderService;
use App\Business\Services\OrderService;
use App\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

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
     * @param CheckoutOrderService $checkoutOrderService
     * @param OrderService $orderService
     */
    public function __construct(CheckoutOrderService $checkoutOrderService, OrderService $orderService)
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
        $bar = $this->output->createProgressBar($orders->count());

        foreach ($this->orderService->toCancelByInactivity() as $order) {
            $this->checkoutOrderService->setOrder($order);
            $this->checkoutOrderService->cancel(trans('checkout.order_cancelled_inactivity'));
            $bar->advance();
        }

        $bar->finish();
    }
}
