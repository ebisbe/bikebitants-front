<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNameToPaymentMethod extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::collection('payment_methods')->where('code', 'paypal')->update(['slug' => 'paypal']);
        DB::collection('payment_methods')->where('code', 'redsys')->update(['slug' => 'redsys']);
        DB::collection('payment_methods')->where('name', 'Pago contra reembolso')->update(['slug' => 'delayed-delivery']);
        DB::collection('payment_methods')->where('name', 'Pago via transferencia bancaria')->update(['slug' => 'bank-transfer']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
