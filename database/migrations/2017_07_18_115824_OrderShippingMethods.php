<?php

use App\Business\Repositories\PaymentMethodRepository;
use App\PaymentMethod;
use Illuminate\Database\Migrations\Migration;

class OrderShippingMethods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $repository = new PaymentMethodRepository();

        $paymentMethod = $repository->findBy('slug', PaymentMethod::REDSYS);
        $repository->update(
            $paymentMethod->id,
            ['order' => 1, 'short_description' => 'Pago seguro a través de tarjeta de crédito. Serás redirigido al sitio web del banco de forma segura.']
        );

        $paymentMethod = $repository->findBy('slug', PaymentMethod::PAYPAL);
        $repository->update(
            $paymentMethod->id,
            ['order' => 2, 'short_description' => 'Si no tienes una cuenta de PayPal, también puedes pagar con tu tarjeta de crédito.']
        );

        $paymentMethod = $repository->findBy('slug', PaymentMethod::PAGA_MAS_TARDE);
        $repository->update(
            $paymentMethod->id,
            ['order' => 3, 'short_description' => 'Realiza tu pago directamente en nuestra cuenta bancaria. El pedido no será enviado hasta que recibamos el comprobante de la transferencia.']
        );

        $paymentMethod = $repository->findBy('slug', PaymentMethod::BANK_TRANSFER);
        $repository->update(
            $paymentMethod->id,
            ['order' => 4, 'short_description' => 'Realiza tu pago en cómodos plazos. Serás redirigido a la plataforma segura de pago para elegir el número de cuotas y finalizar el proceso.']
        );

        $paymentMethod = $repository->findBy('slug', PaymentMethod::CASH_ON_DELIVERY);
        $repository->update(
            $paymentMethod->id,
            ['order' => 5, 'short_description' => 'Podrás pagar en el momento de la entrega, pero solamente en efectivo.']
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
