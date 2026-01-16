<?php

namespace App\Notifications;

use App\Channels\CustomFCMChannel;
use App\Channels\NotificationChannel;
use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;

class NewMessageSent extends Notification
{
    use Queueable;

    const TITLE = 'New Message Received';
    const BODY = 'You Got New Message Please Check Your inbox';

    protected Message $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [/* 'database', */ CustomFCMChannel::class];
    }

    public function toDatabase($notifiable)
    {
        // app()->setLocale('ar');        
        return [
            'notification_id' => $this->id,
            'unread_messages' => $notifiable->unreadNotifications()->count(),
            'type' => getClassName($this),
            'id' => $this->message->chat_id,
            'title' =>
                self::TITLE . ' from' . ' ' . $this->message->sender->name,
            'title_ar' =>
                self::TITLE .
                ' ' .
                __(' from') .
                ' ' .
                $this->message->sender->name,
            'title_en' => __(self::TITLE),
            'patient_id' => $this->message?->chat?->patient_id,
            'date' => $this->message->created_at->toDateString(),
            'message' => $this->message->message,
            'body' => $this->message->message,
            'sender' => $this->message->sender->name,
        ];
    }

    public function toFcm($notifiable)
    {
        return firebaseInit(
            $this->toDatabase($notifiable),
            self::TITLE,
            $this->message->message,
        );
    }
}
