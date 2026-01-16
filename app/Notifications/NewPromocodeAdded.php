<?php

namespace App\Notifications;

use App\Channels\CustomFCMChannel;
use App\Models\Promocode;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;

class NewPromocodeAdded extends Notification
{
    use Queueable;

    const title = 'promocode Added';
    protected $promocode;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Promocode $promocode)
    {
        //
        $this->promocode = $promocode;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['database', FcmChannel::class, CustomFCMChannel::class];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable): array
    {
        app()->setLocale('ar');
        $type = [
            'package' => 'Messaging Package',
            'reservation' => 'New Call',
        ];

        return [
            'notification_id' => $this->id,
            'unread_messages' => $notifiable->unreadNotifications()->count(),
            'type' => getClassName($this),
            'id' => $this->promocode->id,
            'title' => self::title,
            'title_en' => self::title,
            'title_ar' => __(self::title),
            'code' => $this->promocode->code,
            'date' => optional($this->promocode->created_at)->toDateString(),
            'message_ar' =>
                __('Congrats, You Have Got New Promocode For ') .
                __($type[$this->promocode->type]) .
                __(',Just Copy The Code and Use It ') .
                $this->promocode->code,
            'message_en' =>
                'Congrats, You Have Got New Promocode For ' .
                $type[$this->promocode->type] .
                ',Just Copy The Code and Use It ' .
                $this->promocode->code,
            'message' =>
                'Congrats, You Have Got New Promocode For ' .
                $type[$this->promocode->type] .
                ',Just Copy The Code and Use It ' .
                $this->promocode->code,
            'body' =>
                'Congrats, You Have Got New Promocode For ' .
                $type[$this->promocode->type] .
                ',Just Copy The Code and Use It ' .
                $this->promocode->code,
        ];
    }

    public function toFcm($notifiable): \NotificationChannels\Fcm\FcmMessage
    {
        $data = $this->toDatabase($notifiable);

        return firebaseInit(
            $this->toDatabase($notifiable),
            self::title,
            $data['message'],
        );
    }
}
