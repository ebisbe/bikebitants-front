<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPagarMasTarde extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::collection('payment_methods')->insert([
            [
                'name' => 'Pagar a plazos con Paga+Tarde',
                'short_description' => 'Paga en comodos plazos.',
                'description' => '',
                'code' => 'PagaMasTarde',
                'slug' => 'paga-mas-tarde',
                'set_paid' => true,
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
