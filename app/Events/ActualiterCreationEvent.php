<?php

namespace App\Events;

use App\Models\Actualite;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ActualiterCreationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Actualite $actualite;
    /**
     * Create a new event instance.
     */
    public function __construct(Actualite $actualite)
    {
        $this->actualite = $actualite;
    }

    public function getActuaite()
    {
        return $this->actualite;
    }

}
