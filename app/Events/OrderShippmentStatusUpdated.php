<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderShippmentStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message = 'Votre commande a été mise à jour, veuillez verifier votre email pour plus de détails.';

    public  $order_id = 1;



    /**
     * Create a new event instance.
     */
    public function __construct($order_id, $message)
    {
        $this->order_id = $order_id;
        $this->message = $message ?? $this->message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('order.'.$this->order_id)
        ];
    }

    public function broadcastAs(): string
    {
        return 'order.shippment.status.updated';
    }

    public function broadcastWith(): array
    {
        return [
            'order_id' => $this->order_id,
            'message' => $this->message
        ];
    }


    public function broadcastWhen(): bool
    {
        return true;
    }


    public function broadcastShouldQueue(): bool
    {
        return true;
    }


    public function broadcastWithTags(): array
    {
        return ['order', 'shippment', 'status', 'updated'];
    }
}
