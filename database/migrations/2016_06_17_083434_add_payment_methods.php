<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentMethods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
        });

        DB::collection('payment_methods')->insert([
            [
                'name' => 'Pay via Credit Card',
                'short_description' => '',
                'description' => '',
                'code' => 'redsys',
            ],
            [
                'name' => 'PayPal',
                'short_description' => '',
                'description' => '',
                'code' => 'paypal',
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('payment_methods');
    }
}
