<?php

namespace App\Notifications;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OrderPushed extends Notification implements ShouldQueue
{
    use Queueable;
    /** @var  Order $order */
    protected $order;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return SlackMessage
     */
    public function toSlack($notifiable)
    {
        $url = "https://blog.bikebitants.com/wp-admin/post.php?post={$this->order->external_id}&action=edit";

        return (new SlackMessage)
            ->success()
            ->from(config('slack.default_username'), config('slack.default_emoji'))
            ->to(config('slack.channel'))
            ->content('New order!')
            ->attachment(function ($attachment) use ($url) {
                $attachment->title('Order '. $this->order->external_id, $url)
                    ->fields([
                        'Buyer' => $this->order->shipping->first_name. ' '. $this->order->shipping->last_name,
                        'Amount' => $this->order->total,
                        'Email' => $this->order->shipping->email,
                        'Via' => $this->order->payment_method->name,
                    ]);
            });
    }
}
