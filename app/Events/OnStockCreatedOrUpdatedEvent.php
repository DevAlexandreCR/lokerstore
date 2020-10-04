<?php

namespace App\Events;

use App\Models\Stock;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OnStockCreatedOrUpdatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Stock $stock;

    /**
     * OnStockCreatedOrUpdatedEvent constructor.
     * @param Stock $stock
     */
    public function __construct(Stock $stock)
    {
        $this->stock = $stock;
    }

    /**
     * @return PrivateChannel
     */
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('channel-name');
    }
}
