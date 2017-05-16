<?php

namespace App\Mail;

use Illuminate\Support\Collection;

class NotifyProviderDeliverea extends InformProviderToSendSale
{
    public function __construct(Collection $items, $external_id)
    {
        $this->view_name = 'emails.shipments.notify_provider_deliverea';
        parent::__construct($items, $external_id);
    }
}