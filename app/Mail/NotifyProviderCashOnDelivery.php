<?php

namespace App\Mail;

use Illuminate\Support\Collection;

class NotifyProviderCashOnDelivery extends InformProviderToSendSale
{
    public function __construct(Collection $items, $external_id)
    {
        $this->view_name = 'emails.shipments.notify_provider_cash_on_delivery';
        parent::__construct($items, $external_id);
    }
}