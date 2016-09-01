<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('_id');
            $table->unique('name');
            $table->string('magnitude');
            $table->string('type');
            $table->date('expired_at');
            $table->integer('minimum_cart');
            $table->integer('maximum_cart');
            $table->integer('limit_usage_by_coupon');
            $table->integer('limit_usage_by_user');
            $table->boolean('single_use');
            $table->string('emails');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('coupons');
    }
}
