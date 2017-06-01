<?php

namespace App\Business\Deliverea;

class VirtualOperator extends Carrier
{
    const CARRIER = 'ovirtual';
    const SERVICE = 'ovirtual-servicio-19';

    public function __construct()
    {
        parent::__construct(self::CARRIER, self::SERVICE);
    }
}