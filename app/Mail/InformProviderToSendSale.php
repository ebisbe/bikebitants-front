<?php

namespace App\Mail;

use App\Shipping;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;

class InformProviderToSendSale extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    /**
     * @var
     */
    protected $view_name;
    /**
     * @var Collection
     */
    public $items;
    /**
     * @var null
     */
    public $pdf;
    public $to_address;
    public $external_id;

    /**
     * Create a new message instance.
     * @param Collection $items
     * @param $external_id
     */
    public function __construct(Collection $items, $external_id)
    {
        $this->items = $items;
        $this->external_id = $external_id;
    }

    /**
     * @param $pdf
     */
    public function pdfLabel($pdf)
    {
        $this->pdf = $pdf;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this
            ->subject("[Bikebitants] Nuevo pedido '{$this->external_id}'")
            ->replyTo('miguel@bikebitants.com')
            ->markdown($this->view_name);

        if (!is_null($this->pdf)) {
            $email->attachData(base64_decode($this->pdf), 'label.pdf', [
                'mime' => 'application/pdf',
            ]);
        }

        return $email;
    }
}
