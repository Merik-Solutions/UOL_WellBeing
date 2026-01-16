<?php

namespace App\Notifications;

use App\Models\Doctor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DoctorStatusChanged extends Notification
{
    use Queueable;

    protected $doctor;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Doctor $doctor)
    {
        //
        $this->doctor = $doctor;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [/* 'mail', */ 'database'];
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
            ->line('Hello ' . $this->doctor->name)
            ->line('Your account have been activited')
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param \App\Models\User|\App\Models\Doctor $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        app()->setLocale('ar');
        return [
            'notification_id' => $this->id,
            'unread_messages' => $notifiable->unreadNotifications()->count(),
            'title' => 'Status Changed',
            'type' => getClassName($this),
            'title_en' => 'Status Changed',
            'title_ar' => __('Status Changed'),
            'id' => $this->doctor->id,
            'date' => now()->toDateString(),
            'message' => $this->doctor->status
                ? 'Congrats,Your Account Activated'
                : 'Sorry, Your Account Deactivated',
            'body' => $this->doctor->status
                ? 'Congrats,Your Account Activated'
                : 'Sorry, Your Account Deactivated',
            'message_en' => $this->doctor->status
                ? 'Congrats,Your Account Activated'
                : 'Sorry, Your Account Deactivated',
            'message_ar' => $this->doctor->status
                ? 'تهانينا تم تفعيل حسابكم بنجاح'
                : __('نأسف تم تعطيل حسابكم'),
        ];
    }
}
