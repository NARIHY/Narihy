<?php

namespace App\Events;

use App\Models\Portfolio;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PortfolioCreateEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Portfolio $portfolio;
    /**
     * Create a new event instance.
     */
    public function __construct(Portfolio $portfolio)
    {
        $this->portfolio = $portfolio;
    }


}
