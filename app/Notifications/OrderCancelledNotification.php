<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCancelledNotification extends Notification
{
    use Queueable;

    public string $orderNumber;


    /**
     * Create a new notification instance.
     */
    public function __construct(string $orderNumber)
    {
        $this->orderNumber = $orderNumber;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Commande annulée')
                    ->line('Votre commande n°'.$this->orderNumber.' a été annulée.')
                    ->action('Voir les détails', url('/'))
                    ->line('Merci de votre confiance.')
                    ->salutation('L\'équipe '.config('app.name'));
    }


    public function toDatabase(object $notifiable): array
    {
        return [
            'order_number' => $this->orderNumber,
            'message' => 'Votre commande a été annulée.'
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_number' => $this->orderNumber,
            'message' => 'Votre commande a été annulée.'
        ];
    }
}
