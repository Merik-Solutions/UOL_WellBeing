<?php

namespace App\Notifications;

use App\Channels\CustomFCMChannel;
use App\Models\ReservationRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;

class NewReservationRequest extends Notification
{
    use Queueable;

    protected ReservationRequest $reservation_request;
    const title = 'new reservation request';

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ReservationRequest $reservation_request)
    {
        //
        $this->reservation_request = $reservation_request;
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
            'type' => getClassName($this),
            'id' => $this->reservation_request->id,
            'title' => self::title,
            'title_en' => self::title,
            'title_ar' => __(self::title),
            'date' => $this->reservation_request->created_at->toDateString(),
            'message' => $this->getMessage(),
            'body' => $this->getMessage(),
            'message_ar' => $this->getArabicMessage(),
            'message_en' => $this->getMessage(),
        ];
    }

    public function getMessage(): string
    {
        return 'Appointment no ' .
            $this->reservation_request->reservation_id .
            'With Doctor' .
            $this->reservation_request->reservation->doctor->name .
            'Has Change Request To Be At' .
            $this->reservation_request->date;
    }

    public function getArabicMessage(): string
    {
        return __('Reservation no ') .
            $this->reservation_request->reservation_id .
            __('With Doctor') .
            $this->reservation_request->reservation->doctor->name .
            __('Has Chage Request To Be At') .
            $this->reservation_request->date .
            __('You Can Move To Reservation To Accept It');
    }

    public function toFcm($notifiable): \NotificationChannels\Fcm\FcmMessage
    {
        return firebaseInit(
            $this->toDatabase($notifiable),
            self::title,
            $this->getMessage(),
        );
    }
}
