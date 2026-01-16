<?php

namespace App\Notifications;

use App\Channels\CustomFCMChannel;
use App\Models\Doctor;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use PhpParser\Comment\Doc;

class ReservationCallStart extends Notification
{
    use Queueable;

    protected Reservation $reservation;

    const title = 'Call Started';
    const message = 'Call Started';
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public string $sms;

    public function __construct(Reservation $reservation, $link = '')
    {
        $this->reservation = $reservation;
        $this->sms = __('Call Started to join hit the link') . '  ' . $link;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param User|Doctor $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['database', FcmChannel::class, CustomFCMChannel::class];
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
        return [
            'notification_id' => $this->id,
            'unread_messages' => $notifiable->unreadNotifications()->count(),
            'type' => getClassName($this),
            'id' => $this->reservation->id,
            'title' => self::title,
            'title_ar' => self::title,
            'title_en' => __(self::title),
            'date' => now()->toDateString(),
            'message' =>
                __('Your appointment with Dr') .
                ' ' .
                $this->reservation->doctor?->name .
                ' ' .
                __('is has started start'),
            'body' =>
                __('Your appointment with Dr') .
                ' ' .
                $this->reservation->doctor?->name .
                ' ' .
                __('is has started start'),
            'message_ar' =>
                __('Your appointment with Dr') .
                ' ' .
                $this->reservation->doctor?->name .
                ' ' .
                __('is has started start'),
            'message_en' =>
                'Your appointment with Dr' .
                ' ' .
                $this->reservation->doctor?->name .
                ' ' .
                'is has started start',
        ];
    }

    public function toFcm($notifiable): FcmMessage
    {
        return firebaseInit(
            $this->toDatabase($notifiable),
            self::title,
            'Your appointment with Dr' .
                ' ' .
                $this->reservation->doctor?->name .
                ' ' .
                'is has started start',
        );
    }
}
