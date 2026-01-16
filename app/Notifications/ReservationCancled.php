<?php

namespace App\Notifications;

use App\Channels\CustomFCMChannel;
use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;

class ReservationCancled extends Notification
{
    use Queueable;
    const title = 'reservation Canceled';
    const message = 'reservation Canceled';
    protected $reservation;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Reservation $reservation)
    {
        //
        $this->reservation = $reservation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', FcmChannel::class, CustomFCMChannel::class];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        app()->setLocale('ar');
        return [
            'notification_id' => $this->id,
            'unread_messages' => $notifiable->unreadNotifications()->count(),
            'type' => getClassName($this),
            'title' => self::title,
            'title_en' => self::title,
            'title_ar' => __(self::title),
            'id' => $this->reservation->id,
            'date' => $this->reservation->created_at->toDateString(),
            'message' =>
                __('Your appointment with Dr ') .
                $this->reservation->doctor->name .
                __(' is has cancelled'),
            'body' =>
                __('Your appointment with Dr ') .
                $this->reservation->doctor->name .
                __(' is has cancelled'),
            'message_en' =>
                'Your appointment with Dr ' .
                $this->reservation->doctor->name .
                ' is has cancelled',
            'message_ar' =>
                __('Your appointment with Dr ') .
                $this->reservation->doctor->name .
                __(' is has cancelled'),
        ];
    }
    public function toFcm($notifiable)
    {
        return firebaseInit(
            $this->toDatabase($notifiable),
            self::title,
            'Your appointment with Dr ' .
                $this->reservation->doctor->name .
                ' is has cancelled',
        );
    }
}
