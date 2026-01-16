<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Auth\User;

class NotifyUser implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $user;
    private $user_type;
    private $event;
    public $data;
    public $type;

    /**
     * Create a new event instance.
     *
     * @param User $user
     * @param $user_type
     * @param $event
     * @param array $data
     */
    public function __construct(
        User $user,
        $user_type,
        $event,
        $data = [],
        $type = null,
    ) {
        $this->user = $user;
        $this->user_type = $user_type;
        $this->event = $event;
        $this->data = $data;
        $this->type = $type;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel(
            'App.notifications.' . $this->user_type . '.' . $this->user->id,
        );
    }

    /**
     * @return mixed
     */
    public function broadcastAs()
    {
        return $this->event;
    }
}
