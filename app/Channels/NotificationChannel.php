<?php

namespace App\Channels;

use Fcm\FcmClient;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class NotificationChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        Log::info(static::message($notification));
    }
    public static function message(Notification $notification)
    {
        return __('New Message Received From') .
            ' ' .
            $notification->message->sender->name .
            ' : `' .
            $notification->message->message;
    }
}
