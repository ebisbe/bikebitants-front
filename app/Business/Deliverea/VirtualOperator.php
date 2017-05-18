<?php

namespace App\Business\Deliverea;

class VirtualOperator extends Carrier
{
    const CARRIER = 'ovirtual';
    const SERVICE = 'ovirtual-entrega-oficina';

    public function __construct()
    {
        parent::__construct(self::CARRIER, self::SERVICE);
    }
}