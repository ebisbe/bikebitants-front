<?php

namespace App\Mail;

class NotifyProviderCashOnDelivery extends InformProviderToSendSale
{
    public function __construct(array $items, $external_id)
    {
        $this->view_name = 'emails.shipments.notify_provider_cash_on_delivery';
        parent::__construct($items, $external_id);
    }
}