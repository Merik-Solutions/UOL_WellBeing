<?php

namespace App\Services\FCM;
use NotificationChannels\Fcm\Resources\AndroidConfig as MainAndroidConfig;

class AndroidConfig extends MainAndroidConfig
{
    public function toArray(): array
    {
        return parent::toArray() + [
            'content_available' => true,
        ];
    }
}
