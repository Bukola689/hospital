<?php

namespace App\Events\Nurse;

use App\Models\Nurse;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NurseProfile
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $nurse;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Nurse $nurse)
    {
        $this->nurse = $nurse;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
