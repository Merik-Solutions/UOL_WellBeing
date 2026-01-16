<?php

namespace App\Notifications;

use App\Channels\CustomFCMChannel;
use App\Models\Package;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;
use NotificationChannels\Fcm\Resources\FcmOptions;
use NotificationChannels\Fcm\Resources\WebpushConfig;

class NewPackageSubscribed extends Notification
{
    use Queueable;

    protected $package;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    const title = 'new subscription';
    const message = 'Congrats,You Have A new Subscription';

    public function __construct(Package $package)
    {
        //
        $this->package = $package;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', FcmChannel::class,CustomFCMChannel::class];
    }

    public function data($notifiable): array
    {
        app()->setLocale('ar');
        return [
            'notification_id' => $this->id,
            'unread_messages' => $notifiable->unreadNotifications()->count(),
            'type' => getClassName($this),
            'id' => $this->package->id,
            'title_en' => self::title,
            'title' => self::title,
            'title_ar' => __(self::title),
            'date' => optional(
                optional($this->package)->created_at,
            )->toDateString(),
            'message_en' => self::message,
            'message' => self::message,
            'body' => self::message,
            'message_ar' => __(self::message),
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
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
    public function toDatabase($notifiable)
    {
        return $this->data($notifiable);
    }

    public function toFcm($notifiable)
    {
        return firebaseInit($this->data($notifiable), self::title, self::message);
    }
}
