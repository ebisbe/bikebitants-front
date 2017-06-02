<?php

namespace App\Notifications;

use App\Mail\NotifyProvider;
use App\Mail\NotifyProviderCashOnDelivery;
use App\Mail\NotifyProviderDeliverea;
use App\Shipment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class InformProviderToSendSale extends Notification implements ShouldQueue
{
    use Queueable;
    /**
     * @var bool
     */
    private $is_cash_on_delivery;

    /**
     * Create a new notification instance.
     *
     * @param bool $is_cash_on_delivery
     * @internal param $order
     */
    public function __construct(bool $is_cash_on_delivery)
    {
        $this->is_cash_on_delivery = $is_cash_on_delivery;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return !empty($notifiable->notify_to) ? ['mail', 'slack'] : ['slack'];
    }

    /**
     * Get the mail representation of the notification.
     * @param Shipment $notifiable
     */
    public function toMail(Shipment $notifiable)
    {
        if (!empty($notifiable->carrier_code)) {
            if ($this->is_cash_on_delivery) {
                $email = new NotifyProviderCashOnDelivery($notifiable->group, $notifiable->order->external_id);
            } else {
                $email = new NotifyProviderDeliverea($notifiable->group, $notifiable->order->external_id);
            }

            $email->pdfLabel($notifiable->label['label_raw']);
        } else {
            $email = new NotifyProvider(
                $notifiable->group,
                $notifiable->order->external_id,
                $notifiable->order->shipping->toArray()
            );
        }


        return $email->to($notifiable->notify_to)->bcc('miguel@bikebitants.com');
    }

    /**
     * @param Shipment $notifiable
     */
    public function toSlack(Shipment $notifiable)
    {
        if (!empty($notifiable->carrier_code)) {
            $message = $this->carrierMessage($notifiable);
        } else {
            $message = $this->emailMessage($notifiable);
        }

        return $message->success()
            ->from(config('slack.default_username'), config('slack.default_emoji'))
            ->to(config('slack.channel'));
    }

    /**
     * @param Shipment $notifiable
     * @return $this
     */
    protected function carrierMessage(Shipment $notifiable)
    {
        $message = (new SlackMessage)
            ->content('New delivery created')
            ->attachment(function ($attachment) use ($notifiable) {
                $attachment->fields([
                    'Carrier' => $notifiable->carrier_code,
                    'Service' => $notifiable->carrier_service,
                    'Email' => !empty($notifiable->notify_to)
                        ? implode(',', $notifiable->notify_to) : 'No email sent',
                ]);
            });
        return $message;
    }

    /**
     * @param Shipment $notifiable
     * @return $this
     */
    protected function emailMessage(Shipment $notifiable)
    {
        $message = (new SlackMessage)
            ->content('Notification to provider')
            ->attachment(function ($attachment) use ($notifiable) {
                $attachment
                    ->fields([
                        'Email' => !empty($notifiable->notify_to)
                            ? implode(',', $notifiable->notify_to) : 'No email sent',
                    ]);
            });

        return $message;
    }
}
