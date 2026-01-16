<?php

namespace App\Notifications;

use App\Channels\CustomFCMChannel;
use App\Models\Doctor;
use App\Models\Prescription;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class NewPrescriptionAdded extends Notification
{
    use Queueable;

    const title = 'New Prescription Added';
    protected Prescription $prescription;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Prescription $prescription)
    {
        $this->prescription = $prescription;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return [
            'database',
            FcmChannel::class,
            CustomFCMChannel::class,
            // TwilioChannel::class,
        ];
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
            'title_ar' => __(self::title),
            'id' => $this->prescription->id,
            'date' => $this->prescription->created_at->toDateString(),
            'message' => $this->getMessage(),
            'body' => $this->getMessage(),
            'message_en' => $this->getMessage(),
            'message_ar' => $this->getArabicMessage(),
        ];
    }

    public function getMessage(): string
    {
        return 'A new prescription by Dr ' .
            $this->prescription->doctor->name .
            ' has been added, Please click on below link to view it';
    }

    public function getArabicMessage(): array|string|\Illuminate\Contracts\Translation\Translator|\Illuminate\Contracts\Foundation\Application|null
    {
        return __($this->getMessage());
    }

    public function toFcm($notifiable): \NotificationChannels\Fcm\FcmMessage
    {
        return firebaseInit(
            $this->toDatabase($notifiable),
            self::title,
            $this->getMessage(),
        );
    }

    /**
     * @param User $notifiable
     * @return TwilioSmsMessage
     */
    public function toTwilio($notifiable): TwilioSmsMessage
    {
        $current_local = app()->getLocale();
        app()->setLocale($notifiable->locale);
        $sms =
            __('New Prescrption Has been added click  on :-  ') .
            route('printPrescription', $this->prescription);
        app()->setLocale($current_local);
        return (new TwilioSmsMessage())->content($sms);
    }
}
