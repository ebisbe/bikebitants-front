<?php

namespace App\Console\Commands;

use App\Business\Services\OrderService;
use App\Order;
use Carbon\Carbon;
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
     * ExpireOrder constructor.
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        parent::__construct();
        $this->orderService = $orderService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $breakPoint = Carbon::now()->addSeconds(env('ORDER_EXPIRE_TIME', -3600));
        $orders = Order::where('created_at', '<', $breakPoint)
            ->where('status', '>', Order::Cancelled)
            ->get();
        $bar = $this->output->createProgressBar($orders->count());

        foreach($orders as $order){
            $this->orderService->cancel($order);
            $order->error_message = trans('checkout.order_cancelled_inactivity');
            $order->save();
            $bar->advance();
        }

        $bar->finish();
    }
}
