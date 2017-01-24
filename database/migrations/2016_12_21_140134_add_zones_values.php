<?php

use App\ShippingMethod;
use App\Zone;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddZonesValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->zones();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }

    /**
     * Create Zones
     */
    public function zones()
    {
        $zonesCol = collect([
            [
                'name' => 'España (Península)',
                'state' => ['C', 'VI', 'AB', 'A', 'AL', 'O', 'AV', 'BA', 'B', 'BU', 'CC', 'CA', 'S', 'CS', 'CR', 'CO', 'CU', 'GI', 'GR', 'GU', 'SS', 'H', 'HU', 'J', 'LO', 'LE', 'L', 'LU', 'M', 'MA', 'MU', 'NA', 'OR', 'P', 'PO', 'SA', 'SG', 'SE', 'SO', 'T', 'TE', 'TO', 'V', 'VA', 'BI', 'ZA', 'Z'],
                'shipping_methods' => collect([
                    ['name' => 'Envío 24-48 horas',
                        'cost' => 3.305785123966942,
                        'price_condition' => 0],
                    ['name' => 'Envío gratuito 24-48 horas',
                        'cost' => 0,
                        'price_condition' => 25]
                ])
            ],
            [
                'name' => 'España (Baleares)',
                'state' => ['PM'],
                'shipping_methods' => collect([
                    ['name' => 'Envío 3-4 días',
                        'cost' => 8.264462809917355,
                        'price_condition' => 0],
                    ['name' => 'Envío gratuito 3-4 dias',
                        'cost' => 0,
                        'price_condition' => 25]
                ])
            ],
            [
                'name' => 'España (Canarias)',
                'state' => ['GC', 'TF'],
                'shipping_methods' => collect([
                    ['name' => 'Envío 3-4 dias',
                        'cost' => 25,
                        'price_condition' => 0]
                ])
            ],
            [
                'name' => 'España (Ceuta Melilla)',
                'state' => ['CE', 'ML'],
                'shipping_methods' => collect([
                    ['name' => 'Envío 3-4 dias',
                        'cost' => 25,
                        'price_condition' => 0]
                ])
            ],
        ]);

        $zonesCol->each(function ($item) {
            /** @var Zone $zone */
            $zone = Zone::create([
                'name' => $item['name'],
                'state' => $item['state']
            ]);
            $item['shipping_methods']->each(function ($item) use ($zone) {
                $shippingMethod = new ShippingMethod([
                    'name' => $item['name'],
                    'cost' => $item['cost'],
                    'price_condition' => $item['price_condition'],
                ]);
                $zone->shipping_methods()->save($shippingMethod);
            });
        });
    }
}
