<?php

namespace App\Services\FCM;

use NotificationChannels\Fcm\Resources\ApnsConfig as ResourcesApnsConfig;

class ApnsConfig extends ResourcesApnsConfig
{
    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return [
            'headers' => $this->getHeaders(),
            'payload' => $this->getPayload(),
            'priority' => 'high',
            'content_available' => true,
            'fcm_options' => !is_null($this->getFcmOptions())
                ? $this->getFcmOptions()->toArray()
                : null,
        ];
    }
}
