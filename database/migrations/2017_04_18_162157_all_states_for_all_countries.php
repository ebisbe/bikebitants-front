<?php

use App\Country;
use Illuminate\Database\Migrations\Migration;

class AllStatesForAllCountries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $countries = Country::withOutGlobalScopes()->whereActive(0)->get();

        $countries->each(function ($country) {
            $country->states = [
                '_id' => $country->_id,
                'name' => 'Todas las provincias'
            ];
            $country->save();
        });
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
