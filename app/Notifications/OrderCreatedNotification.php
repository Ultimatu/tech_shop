<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification
{
    use Queueable;

    public string $orderNumber;

    public string $who;

    /**
     * Create a new notification instance.
     */

    public function __construct(string $orderNumber, $who="user")
    {
        $this->orderNumber = $orderNumber;
        $this->who = $who;
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
        if ($this->who == "admin") {
            return (new MailMessage)
                    ->subject('Nouvelle commande')
                    ->line('Une nouvelle commande n°'.$this->orderNumber.' a été passée.')
                    ->action('Voir les détails', route('filament.admin.resources.orders.index'))
                    ->line('Merci de votre confiance.')
                    ->salutation('L\'équipe '.config('app.name'));
        }else 
        return (new MailMessage)
                    ->subject('Commande prise en compte')
                    ->line('Votre commande n°'.$this->orderNumber.' a été prise en compte.')
                    ->action('Voir les détails', url('/'))
                    ->line('Merci de votre confiance.')
                    ->salutation('L\'équipe '.config('app.name'));

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
            'message' => 'Votre commande a été prise en compte.'
        ];
    }
}
