<?php

namespace App\Http\Controllers;

use Deliverea;

class DelivereaController extends Controller
{
    public function clientCarriers()
    {
        $response = Deliverea::getClientCarriers();
        dd($response);
    }

    public function clientServices()
    {
        $response = Deliverea::getClientServices(null, null, null, null, 1);
        dd($response);
    }

    public function serviceInfo()
    {
        $response = Deliverea::getServiceInfo('correosExpress', 'correos-epaq-24', 'ES', '08100', 'ES', '28028');
        dd($response);
    }

    public function cutOffHour()
    {
        $response = Deliverea::getCollectionCutoffHour([
            'zip_code' => '08105',
            'country_code' => 'ES',
            'service_code' => 'ovirtual-servicio-19',
            'carrier_code' => 'ovirtual'
        ]);
        dd($response);
    }

    public function addresses()
    {
        $response = Deliverea::getAddresses();
        dd($response);
    }
}
