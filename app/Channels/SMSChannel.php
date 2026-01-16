<?php

namespace App\Channels;

use Http;
use Illuminate\Notifications\Notification;
use Log;

class SMSChannel
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
        $sms = $notification->sms;
        $config = config('services.mshastra');
        try {
            $response = Http::get($config['url'], [
                'user' => $config['user'],
                'pwd' => $config['pwd'],
                'senderid' => $config['senderid'],
                'mobileno' => $notifiable->phone,
                'msgtext' => $sms,
                'priority' => $config['priority'],
                'CountryCode' => $config['CountryCode'],
            ]);
        } catch (\Exception $e) {
            if (env('APP_ENV') == 'production') {
                throw $e;
            }
        }
    }
}
