<?php

use App\Country;
use App\Province;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSpanishProvinces extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** @var Country $spain */
        $spain = Country::where('_id', 'ES')->first();
        foreach ($this->provinces as $province) {
            $data = new Province();
            $data->_id = $province['_id'];
            $data->name = $province['name'];
            $spain->provinces()->associate($data);
        }
        $spain->save();
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

    public $provinces = [
        ['_id' => "C", 'name' => 'A Coruña'],
        ['_id' => "VI", 'name' => 'Araba/Álava'],
        ['_id' => "AB", 'name' => 'Albacete'],
        ['_id' => "A", 'name' => 'Alicante'],
        ['_id' => "AL", 'name' => 'Almería'],
        ['_id' => "O", 'name' => 'Asturias'],
        ['_id' => "AV", 'name' => 'Ávila'],
        ['_id' => "BA", 'name' => 'Badajoz'],
        ['_id' => "PM", 'name' => 'Baleares'],
        ['_id' => "B", 'name' => 'Barcelona'],
        ['_id' => "BU", 'name' => 'Burgos'],
        ['_id' => "CC", 'name' => 'Cáceres'],
        ['_id' => "CA", 'name' => 'Cádiz'],
        ['_id' => "S", 'name' => 'Cantabria'],
        ['_id' => "CS", 'name' => 'Castellón'],
        ['_id' => "CE", 'name' => 'Ceuta'],
        ['_id' => "CR", 'name' => 'Ciudad Real'],
        ['_id' => "CO", 'name' => 'Córdoba'],
        ['_id' => "CU", 'name' => 'Cuenca'],
        ['_id' => "GI", 'name' => 'Girona/Gerona'],
        ['_id' => "GR", 'name' => 'Granada'],
        ['_id' => "GU", 'name' => 'Guadalajara'],
        ['_id' => "SS", 'name' => 'Gipuzkoa/Guipúzcoa'],
        ['_id' => "H", 'name' => 'Huelva'],
        ['_id' => "HU", 'name' => 'Huesca'],
        ['_id' => "J", 'name' => 'Jaén'],
        ['_id' => "LO", 'name' => 'La Rioja'],
        ['_id' => "GC", 'name' => 'Las Palmas'],
        ['_id' => "LE", 'name' => 'León'],
        ['_id' => "L", 'name' => 'Lleida/Lérida'],
        ['_id' => "LU", 'name' => 'Lugo'],
        ['_id' => "M", 'name' => 'Madrid'],
        ['_id' => "MA", 'name' => 'Málaga'],
        ['_id' => "ML", 'name' => 'Melilla'],
        ['_id' => "MU", 'name' => 'Murcia'],
        ['_id' => "NA", 'name' => 'Navarra'],
        ['_id' => "OR", 'name' => 'Ourense/Orense'],
        ['_id' => "P", 'name' => 'Palencia'],
        ['_id' => "PO", 'name' => 'Pontevedra'],
        ['_id' => "SA", 'name' => 'Salamanca'],
        ['_id' => "TF", 'name' => 'Santa Cruz de Tenerife'],
        ['_id' => "SG", 'name' => 'Segovia'],
        ['_id' => "SE", 'name' => 'Sevilla'],
        ['_id' => "SO", 'name' => 'Soria'],
        ['_id' => "T", 'name' => 'Tarragona'],
        ['_id' => "TE", 'name' => 'Teruel'],
        ['_id' => "TO", 'name' => 'Toledo'],
        ['_id' => "V", 'name' => 'Valencia'],
        ['_id' => "VA", 'name' => 'Valladolid'],
        ['_id' => "BI", 'name' => 'Bizkaia/Vizcaya'],
        ['_id' => "ZA", 'name' => 'Zamora'],
        ['_id' => "Z", 'name' => 'Zaragoza']
    ];
}
