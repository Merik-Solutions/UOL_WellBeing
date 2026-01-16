<?php

namespace App\Notifications;

use App\Channels\CustomFCMChannel;
use App\Channels\NotificationChannel;
use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;

class ReservationApproch extends Notification
{
    use Queueable;

    protected $reservation;

    const title = 'Reservation Approches';
    const message = 'Reservation Will Start Soon';

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['database', FcmChannel::class, CustomFCMChannel::class];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toDatabase($notifiable): array
    {
        app()->setLocale('ar');
        return [
            'notification_id' => $this->id,
            'unread_messages' => $notifiable->unreadNotifications()->count(),

            'id' => $this->reservation->id,
            'title' => self::title,
            'title_en' => self::title,
            'title_ar' => __(self::title),
            'date' => $this->reservation->created_at->toDateString(),
            'message' =>
                __('Your appointment with Dr') .
                $this->reservation->doctor->name_ar .
                __('is about to start, Please be ready'),
            'body' =>
                __('Your appointment with Dr') .
                $this->reservation->doctor->name_ar .
                __('is about to start, Please be ready'),
            'message_en' =>
                'Your appointment with Dr' .
                ' ' .
                $this->reservation->doctor?->name .
                'is has started start',
            'message_ar' =>
                __('Your appointment with Dr') .
                $this->reservation->doctor->name_ar .
                __('is about to start, Please be ready'),
            'type' => getClassName($this),
        ];
    }

    public function toFcm($notifiable): \NotificationChannels\Fcm\FcmMessage
    {
        return firebaseInit(
            $this->toDatabase($notifiable),
            self::title,
            'Your appointment with Dr' .
                ' ' .
                $this->reservation->doctor?->name .
                'is has started start',
        );
    }
}
