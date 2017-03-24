<?php

namespace App\Console\Commands;

use App\Business\Checkout\Events\Confirm;
use App\Business\Services\OrderService;
use Illuminate\Console\Command;
use Event;

class PushOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:push';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Push all confirmed orders that for some reason are not pushed to wordpress.';

    protected $orderService;


    /**
     * PushOrder constructor.
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
        $orders = $this->orderService->notPushedToWordPress();
        $bar = $this->output->createProgressBar($orders->count());

        foreach ($orders as $order) {
            Event::fire(new Confirm($order));
            $bar->advance();
        }

        $bar->finish();
    }

}
