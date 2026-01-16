<?php

namespace App\Events\Chat;

use App\Http\Resources\Chat\MessageResource;
use App\Models\Message;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $msg_html;
    /**
     * @var string|null
     */
    private $type;
    private $chat_id;

    /**
     * MessageSent constructor.
     * @param Message $message
     * @param string $type
     * @param bool $include_html
     * @throws \Throwable
     */
    public function __construct(Message $message)
    {
        $this->chat_id = $message->chat_id;
        $this->loadMessage($message);
        $this->loadHtml($message);
    }

    public function broadcastOn()
    {
        return new PrivateChannel('App.chat.' . $this->chat_id);
    }

    public function broadcastAs()
    {
        return 'new-message';
    }

    public function loadHtml($message)
    {
        $this->msg_html = view('website.partials._chat_message', [
            'message' => $message,
            'type' => 'doctor',
        ])->render();
    }

    public function loadMessage($message)
    {
        $this->message = (new MessageResource($message))->jsonSerialize();
    }
}
