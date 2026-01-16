<?php

namespace App\Models;

use App\Repositories\interfaces\ChatRepository;
use App\Traits\ModelHasLogs;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * App\Models\Chat
 *
 * @property int $id
 * @property int $doctor_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Doctor $doctor
 * @property-read \App\Models\Message $last_message
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Message[] $messages
 * @property-read int|null $messages_count
 * @property-read \App\Models\User $user
 * @mixin IdeHelperChat
 */
class Chat extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $fillable = ['doctor_id', 'user_id', 'patient_id'];

    public function messages()
    {
        return $this->hasMany(Message::class)->with('sender');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    /**
     * get last message depends on scopeLastMessageId
     *
     * @return BelongsTo
     */
    public function last_message(): BelongsTo
    {
        return $this->belongsTo(Message::class, 'last_message_id');
    }

    public function scopeOfDoctor(Builder $builder, $value): void
    {
        $builder->where('doctor_id', $value);
    }

    public function scopeOfPatient(Builder $builder, $value): void
    {
        $builder->where('patient_id', $value);
    }

    public function scopeLastMessage(Builder $builder)
    {
        $builder->AddSelect([
            'last_message' => Message::query()
                ->select('message')
                ->whereColumn('messages.chat_id', 'chats.id')
                ->latest()
                ->limit(1),
        ]);
    }
    public function scopeWithAvailableToSend(Builder $builder)
    {
        $builder->AddSelect([
            'available_to_send' => UserDoctorPackage::query()
                ->join(
                    'packages',
                    'packages.id',
                    'user_doctor_packages.package_id',
                )
                ->whereColumn('user_doctor_packages.user_id', 'chats.user_id')
                ->whereColumn('user_doctor_packages.patient_id', 'chats.patient_id')
                ->whereColumn(
                    'user_doctor_packages.doctor_id',
                    'chats.doctor_id',
                )
                ->IsAvailable()
                ->groupBy('user_id', 'doctor_id','patient_id')
                ->selectRaw('SUM(packages.quantity)')
                ->limit('1'),
            // ->groupBy('doctor_id')
        ]);
    }

    public function scopeLastMessageId(Builder $builder)
    {
        $builder->AddSelect([
            'last_message_id' => Message::query()
                ->select('id')
                ->whereColumn('messages.chat_id', 'chats.id')
                ->latest()
                ->limit(1),
        ]);
    }

    public function scopeUnreadCount(Builder $builder)
    {
        $builder->addSelect([
            'unread_count' => Message::query()
                ->selectRaw('count(IF(isnull(seen_at),0,1))')
                ->whereColumn('messages.chat_id', 'chats.id')
                ->where('sender_type', get_class(auth()->user())),
        ]);
    }
}
