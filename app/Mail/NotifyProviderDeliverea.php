<?php

namespace App\Mail;

class NotifyProviderDeliverea extends InformProviderToSendSale
{
    public function __construct(array $items, $external_id)
    {
        $this->view_name = 'emails.shipments.notify_provider_deliverea';
        parent::__construct($items, $external_id);
    }
}