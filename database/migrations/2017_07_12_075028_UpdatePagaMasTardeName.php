<?php

use App\Business\Repositories\PaymentMethodRepository;
use App\PaymentMethod;
use Illuminate\Database\Migrations\Migration;

class UpdatePagaMasTardeName extends Migration
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
            ['name' => "<div class='js-pmt-payment-type'>Paga +Tarde</div><div class='PmtSimulator hidden' data-pmt-max-ins='12' data-pmt-num-quota='6' data-pmt-style='grey' data-pmt-type='4' data-pmt-discount='0' data-pmt-amount='pvp'> </div>"]
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
