<?php

namespace App\Mail;

class NotifyProvider extends InformProviderToSendSale
{

    public function __construct(array $items, $external_id, $to_address)
    {
        $this->view_name = 'emails.shipments.notify_provider';
        $this->to_address = $to_address;
        parent::__construct($items, $external_id);
    }
}