<?php

namespace App\Notifications;

use App\Channels\CustomFCMChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class SendMessageToPatient extends Notification
{
    use Queueable;

    public $sms;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($sms)
    {
        //
        $this->sms = $sms;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TwilioChannel::class];
    }

    public function toTwilio($notifiable)
    {
        return (new TwilioSmsMessage())->content($this->sms);
    }
}
