<?php

namespace App\Notifications;

use App\Channels\CustomFCMChannel;
use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;

class NewReservationAdded extends Notification
{
    use Queueable;

    const title = 'New Reservation Added';
    protected $reservation;

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
        return [FcmChannel::class, CustomFCMChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage())
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
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
            'title' => self::title,
            'title_en' => self::title,
            'id' => $this->reservation->id,
            'date' => $this->reservation->created_at->toDateString(),
            'message' => $this->getMessage(),
            'body' => $this->getMessage(),
            'message_en' => $this->getMessage(),
            'title_ar' => __(self::title),
            'message_ar' => $this->getArabicMessage(),
        ];
    }

    public function getMessage(): string
    {
        return 'A new appointment has been booked by ' .
            $this->reservation->patient?->name .
            ' ' .
            $this->reservation->date .
            ' at ' .
            $this->reservation->from_time .
            ' : ' .
            $this->reservation->to_time;
    }

    public function getArabicMessage(): string
    {
        return __('New Appointment in') .
            ' ' .
            $this->reservation->date .
            __(' at ') .
            $this->reservation->from_time .
            ' : ' .
            $this->reservation->to_time;
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
