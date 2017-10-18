<?php

use App\Business\Repositories\PaymentMethodRepository;
use App\PaymentMethod;
use Illuminate\Database\Migrations\Migration;

class SwapPaymentTexts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $repository = new PaymentMethodRepository();

        $paymentMethod = $repository->findBy('slug', PaymentMethod::PAGA_MAS_TARDE);
        $repository->update(
            $paymentMethod->id,
            [
                'order' => 3,
                'short_description' => 'Realiza tu pago en cómodos plazos. Serás redirigido a la plataforma segura de pago para elegir el número de cuotas y finalizar el proceso.'
            ]
        );

        $paymentMethod = $repository->findBy('slug', PaymentMethod::BANK_TRANSFER);
        $repository->update(
            $paymentMethod->id,
            [
                'order' => 4,
                'short_description' => 'Realiza tu pago directamente en nuestra cuenta bancaria. El pedido no será enviado hasta que recibamos el comprobante de la transferencia.'
            ]
        );
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
