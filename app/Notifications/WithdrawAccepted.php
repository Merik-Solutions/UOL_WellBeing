<?php

namespace App\Notifications;

use App\Channels\CustomFCMChannel;
use App\Models\WithdrawRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;

class WithdrawAccepted extends Notification
{
    use Queueable;
    const title = 'Withdraw Accepted';
    const message = 'Withdraw Accepted';
    protected $request;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(WithdrawRequest $request)
    {
        //
        $this->request = $request;
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
            'id' => $this->request->id,
            'date' => $this->request->created_at->toDateString(),
            'message' =>
                __('Your withdraw request of ') .
                $this->request->amount .
                __(' is accepted'),
            'body' =>
                __('Your withdraw request of ') .
                $this->request->amount .
                __(' is accepted'),
            'message_en' =>
                'Your withdraw request of ' .
                  $this->request->amount .
                ' is accepted',
            'message_ar' =>
                'Your withdraw request of ' .
                  $this->request->amount .
                ' is accepted',
        ];
    }
    public function toFcm($notifiable)
    {
        return firebaseInit(
            $this->toDatabase($notifiable),
            self::title,
            'Your withdraw request of ' .
                $this->request->amount .
                __(' is accepted'),
        );
    }
}
