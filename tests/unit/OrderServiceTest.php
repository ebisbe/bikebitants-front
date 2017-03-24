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
        $this->createOrdersForCurrentTime(Carbon::now());

        $orders = OrderService::cancelByInactivity();

        $this->assertEquals(0, $orders->count());
    }

    /**
     * @test
     */
    public function do_not_expire_a_cancelled_order_from_ten_minutes()
    {
        $this->createOrdersForCurrentTime(Carbon::now()->addMinutes(-10), 'Cancelled');

        $orders = OrderService::cancelByInactivity();

        $this->assertEquals(0, $orders->count());
    }

    /**
     * @test
     */
    public function do_not_expire_a_confirmed_order_from_ten_minutes()
    {
        $this->createOrdersForCurrentTime(Carbon::now()->addMinutes(-10), 'Confirmed');

        $orders = OrderService::cancelByInactivity();

        $this->assertEquals(0, $orders->count());
    }

    /**
     * @test
     */
    public function do_not_expirea_confirmed_order()
    {
        $this->createOrdersForCurrentTime(Carbon::now(), 'Confirmed');

        $orders = OrderService::cancelByInactivity();

        $this->assertEquals(0, $orders->count());
    }

    /**
     * @test
     */
    public function find_one_order_to_expire()
    {
        $this->createOrdersForCurrentTime(Carbon::now()->addMinutes(-10));

        $orders = OrderService::cancelByInactivity();

        $this->assertEquals(1, $orders->count());
    }

    public function createOrdersForCurrentTime($date, $state = 'New')
    {
        factory(Order::class)->states($state)->create(['created_at' => $date]);
    }

    public function createOrders($state = 'New', $properties = [])
    {
        factory(Order::class)->states($state)->create($properties);
    }



    /** @test */
    public function orders_with_status_confirmed_to_push()
    {
        $this->createOrders('New', ['token' => 1]);
        $this->createOrders('Redirected', ['token' => 2]);
        $this->createOrders('ValidData', ['token' => 3]);
        $this->createOrders('Confirmed', ['token' => 4]);
        $this->createOrders('Cancelled', ['token' => 5]);
        $this->createOrders('Undefined', ['token' => 6]);

        $orders = OrderService::notPushedToWordPress();

        $this->assertCount(1, $orders);
        $this->assertEquals(4, $orders->first()->token);
    }

    /** @test */
    public function confirmed_orders_with_external_id_null()
    {
        $this->createOrders('Confirmed', ['token' => 1, 'external_id' => null]);
        $this->createOrders('Confirmed', ['token' => 2, 'external_id' => '']);
        $this->createOrders('Confirmed', ['token' => 3, 'external_id' => 1]);
        $this->createOrders('Confirmed', ['token' => 4]);
        $this->createOrders('Cancelled', ['token' => 5, 'external_id' => null]);
        $this->createOrders('Undefined', ['token' => 6, 'external_id' => '']);
        $this->createOrders('Undefined', ['token' => 7, 'external_id' => 2]);
        $this->createOrders('Undefined', ['token' => 8]);

        $orders = OrderService::notPushedToWordPress();

        $this->assertCount(3, $orders);
        $this->assertEquals(1, $orders->shift()->token);
        $this->assertEquals(2, $orders->shift()->token);
        $this->assertEquals(4, $orders->shift()->token);
    }
}
