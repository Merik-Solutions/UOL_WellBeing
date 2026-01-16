<?php

namespace App\Models;

use App\Notifications\NewMessageSent;
use App\Traits\ModelHasLogs;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * App\Models\Message
 *
 * @property int $id
 * @property int $chat_id
 * @property string|null $message
 * @property string $sender_type
 * @property int $sender_id
 * @property \Illuminate\Support\Carbon|null $seen_at
 * @property int|null $user_doctor_packages_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Chat $chat
 * @property-read \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\BelongsTo $receiver
 * @property-read bool $user_is_the_sender
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read Model|\Eloquent $sender
 * @mixin IdeHelperMessage
 */
class Message extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $fillable = [
        'chat_id',
        'message',
        'sender_type',
        'sender_id',
        'seen_at',
        'user_doctor_packages_id',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::created(function (Message $message) {
            $message->receiver->notify(new NewMessageSent($message));
        });
    }
    protected $dates = ['seen_at'];

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

    public function sender(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * return the receiver of the message
     *
     * @return Model|BelongsTo
     */
    public function getReceiverAttribute()
    {
        if ($this->User_is_the_sender) {
            return $this->chat->doctor;
        }
        return $this->chat->user;
    }
    /**
     * check if the sender of the message was the user
     *
     * @return bool
     */
    public function getUserIsTheSenderAttribute(): bool
    {
        return $this->sender_type === User::class;
    }
}
