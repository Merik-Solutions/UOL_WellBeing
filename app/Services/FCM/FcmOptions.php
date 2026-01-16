<?php

declare(strict_types=1);

namespace App\Services\FCM;

use NotificationChannels\Fcm\Resources\FcmOptions as MainFcmOptions;

class FcmOptions extends MainFcmOptions
{
    /**
     * @var bool|null
     */
    protected ?bool $contentAvailable;

    /**
     * @return string|null
     */
    public function getContentAvailable(): ?bool
    {
        return $this->contentAvailable;
    }

    /**
     * @param bool|null $contentAvailableLabel
     * @return FcmOptions
     */
    public function setContentAvailable(?bool $contentAvailableLabel): self
    {
        $this->contentAvailable = $contentAvailableLabel;

        return $this;
    }


    /**
     * @return static
     */
    public static function create(): self
    {
        return new self;
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
