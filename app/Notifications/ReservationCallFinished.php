<?php

namespace App\Notifications;

use App\Channels\CustomFCMChannel;
use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;

class ReservationCallFinished extends Notification
{
    use Queueable;

    protected Reservation $reservation;

    const title = 'Call Finished';
    const message = 'Call Finished';

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
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', CustomFCMChannel::class];
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

    public function toDatabase($notifiable): array
    {
        return [
            'notification_id' => $this->id,
            'unread_messages' => $notifiable->unreadNotifications()->count(),

            'id' => $this->reservation->id,
            'title' => self::title,
            'title_en' => self::title,
            'title_ar' => __(self::title),
            'date' => now()->toDateString(),
            'message' =>
                __('Your appointment with Dr ') .
                $this->reservation->doctor->name .
                __(' is has Ended, Thank you for using KindaHealth'),
            'body' =>
                __('Your appointment with Dr ') .
                $this->reservation->doctor->name .
                __(' is has Ended, Thank you for using KindaHealth'),

            'message_en' =>
                'Your appointment with Dr ' .
                $this->reservation->doctor->name .
                'is has Ended, Thank you for using KindaHealth',

            'message_ar' =>
                __('Your appointment with Dr ') .
                $this->reservation->doctor->name .
                __(' is has Ended, Thank you for using KindaHealth'),

            'type' => getClassName($this),
        ];
    }

    public function toFcm($notifiable): \NotificationChannels\Fcm\FcmMessage
    {
        return firebaseInit(
            $this->toDatabase($notifiable),
            self::title,
            'Your appointment with Dr ' .
                $this->reservation->doctor->name .
                'is has Ended, Thank you for using KindaHealth',
        );
    }
}
