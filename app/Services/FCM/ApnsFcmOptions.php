<?php

declare(strict_types=1);

namespace App\Services\FCM;

use NotificationChannels\Fcm\Resources\ApnsFcmOptions as ResourcesApnsFcmOptions;

class ApnsFcmOptions extends ResourcesApnsFcmOptions
{
    /**
     * @var bool|null
     */
    protected ?bool $contentAvailable;

    /**
     * @return bool|null
     */
    public function getContentAvailable(): ?bool
    {
        return $this->contentAvailable;
    }

    /**
     * @param bool|null $contentAvailableLabel
     * @return ApnsFcmOptions
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
