<?php

namespace App\Business\Deliverea;

class CorreosExpress extends Carrier
{
    const CARRIER = 'correosExpress';
    const SERVICE = 'correos-epaq-24';

    public function __construct()
    {
        parent::__construct(self::CARRIER, self::SERVICE);
    }
}