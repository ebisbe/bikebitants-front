<?php

use App\Order;
use Carbon\Carbon;

class OrderServiceTest extends TestCase
{
    protected function tearDown()
    {
        Order::truncate();
    }

    /**
     * @test
     */
    public function do_not_expire_a_new_order()
    {
        $this->createOrders(Carbon::now());

        $orders = OrderService::cancelByInactivity();

        $this->assertEquals(0, $orders->count());
    }

    /**
     * @test
     */
    public function do_not_expire_a_cancelled_order_from_ten_minutes()
    {
        $this->createOrders(Carbon::now()->addMinutes(-10), 'Cancelled');

        $orders = OrderService::cancelByInactivity();

        $this->assertEquals(0, $orders->count());
    }

    /**
     * @test
     */
    public function do_not_expire_a_confirmed_order_from_ten_minutes()
    {
        $this->createOrders(Carbon::now()->addMinutes(-10), 'Confirmed');

        $orders = OrderService::cancelByInactivity();

        $this->assertEquals(0, $orders->count());
    }

    /**
     * @test
     */
    public function do_not_expirea_confirmed_order()
    {
        $this->createOrders(Carbon::now(), 'Confirmed');

        $orders = OrderService::cancelByInactivity();

        $this->assertEquals(0, $orders->count());
    }

    /**
     * @test
     */
    public function find_one_order_to_expire()
    {
        $this->createOrders(Carbon::now()->addMinutes(-10));

        $orders = OrderService::cancelByInactivity();

        $this->assertEquals(1, $orders->count());
    }

    public function createOrders($date, $state = 'New')
    {
        factory(Order::class)->states($state)->create(['created_at' => $date]);
    }
}
