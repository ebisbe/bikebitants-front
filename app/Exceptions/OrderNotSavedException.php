<?php

namespace App\Exceptions;

class OrderNotSavedException extends \Exception
{
    public function __construct($id, $external_id)
    {
        $message = "Unable to save Order with id '{$id}' and external id '{$external_id}'";
        parent::__construct($message);
    }
}
