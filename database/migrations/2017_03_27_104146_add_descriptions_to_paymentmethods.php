<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDescriptionsToPaymentmethods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::collection('payment_methods')
            ->where('slug', 'redsys')
            ->update([
                'name' => 'Pagar mediante tarjeta de crédito'
            ]);

        DB::collection('payment_methods')
            ->where('slug', 'paypal')
            ->update([
                'name' => 'Pagar mediante PayPal'
            ]);

        DB::collection('payment_methods')
            ->where('slug', 'delayed-delivery')
            ->update([
                'name' => 'Pagar contra reembolso',
                'description' => 'Podrás pagar en el momento de la entrega, pero solamente en efectivo.'
            ]);

        DB::collection('payment_methods')
            ->where('slug', 'bank-transfer')
            ->update([
                'name' => 'Pagar via transferencia bancaria',
                'description' => 'Por favor, realiza la transferencia bancaria usando el número de pedido como referencia de pago. Una vez realidada la transferencia, envia el comprobante de la transferencia al email <a href=\"mailto:hola@bikebitants.com\">hola@bikebitants.com</a>. Tu pedido no será enviado hasta que recibamos el comprobante de la transferencia.<br>\n<br>\nBanc Sabadell<br>\nNumero de cuenta<br>\n00815224470001279131<br>\nIBAN<br>\nES9700815224470001279131<br>\nBIC / Swift<br>\nBSAB ESBB'
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
