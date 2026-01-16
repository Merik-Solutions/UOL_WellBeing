<?php

namespace App\Observers;

use App\Events\Chat\MessageSent;
use App\Models\Message;

class PushMessageNotificationObserver
{
    public function created(Message $message)
    {
    }
}
