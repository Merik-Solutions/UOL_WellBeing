<?php

namespace App\Events;

use App\Http\Resources\Reservation\ReservationResource;
use App\Models\Reservation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CallStarted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Reservation
     */
    public $reservation;
    /**
     * @var string
     */
    public $subscriber;

    public function __construct(
        Reservation $reservation,
        string $subscriber = 'doctor',
    ) {
        //
        $this->reservation = new ReservationResource(
            $reservation->load('doctor', 'patient'),
        );
        $this->subscriber = $subscriber;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel(
            'App.calls.' . $this->subscriber . '.' . $this->getSubscriberId(),
        );
    }

    public function broadcastAs()
    {
        return 'new-call';
    }

    /**
     * get the subscriber should receive the call
     * @return int
     */
    public function getSubscriberId(): int
    {
        if ($this->subscriber == 'doctor') {
            return $this->reservation->doctor_id;
        }
        return $this->reservation->patient_id;
    }
}
