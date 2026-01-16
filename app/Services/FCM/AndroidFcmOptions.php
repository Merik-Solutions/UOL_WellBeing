<?php

declare(strict_types=1);

namespace App\Services\FCM;

use NotificationChannels\Fcm\Resources\AndroidFcmOptions as ResourcesAndroidFcmOptions;

class AndroidFcmOptions extends ResourcesAndroidFcmOptions
{
    /**
     * @var bool|null
     */
    protected ?bool $contentAvailable;

    /**
     * @return static
     */
    public static function create(): self
    {
        return new self;
    }
    /**
     * @return string|null
     */
    public function getContentAvailable(): ?bool
    {
        return $this->contentAvailable;
    }

    /**
     * @param  string|null  $analyticsLabel
     * @return ResourcesAndroidFcmOptions
     */
    public function setContentAvailable(?bool $contentAvailableLabel): self
    {
        $this->contentAvailable = $contentAvailableLabel;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return parent::toArray() + [
            'content_available' => $this->getContentAvailable(),
        ];
    }
}
