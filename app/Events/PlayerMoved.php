<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;

class PlayerMoved implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $id;
    public $position;

    public function __construct($id, $position)
    {
        $this->id = $id;
        $this->position = $position;
    }

    public function broadcastWith()
{
    return [
        'id' => $this->id,
        'position' => $this->position
    ];
}


    public function broadcastOn()
    {
        return new Channel('game-channel');
    }

    public function broadcastAs()
    {
        return 'player-moved';
    }
}

