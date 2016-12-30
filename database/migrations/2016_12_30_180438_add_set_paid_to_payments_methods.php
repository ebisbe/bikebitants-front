<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSetPaidToPaymentsMethods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::collection('payment_methods')->update(['set_paid' => true]);

        DB::collection('payment_methods')->insert([
            [
                'name' => 'Pago via transferencia bancaria',
                'short_description' => '',
                'description' => '',
                'code' => 'Fake',
                'set_paid' => false
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
        //
    }
}
