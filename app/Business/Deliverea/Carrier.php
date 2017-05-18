<?php

namespace App\Business\Deliverea;

class Carrier
{
    private $carrier;
    private $service;

    /**
     * Carrier constructor.
     * @param $carrier
     * @param $service
     */
    public function __construct($carrier, $service)
    {
        $this->carrier = $carrier;
        $this->service = $service;
    }

    public function name()
    {
        return $this->carrier;
    }

    public function service()
    {
        return $this->service;
    }
}