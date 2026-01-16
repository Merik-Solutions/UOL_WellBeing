<?php

namespace App\Models;

use App\Traits\ColumnTranslation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Illuminate\Http\UploadedFile;

/**
 * App\Models\AdminNotification
 *
 * @property string $title_ar
 * @property string $title_en
 * @property string $body_en
 * @property string $body_ar
 * @property string $file_url
 * @property bool $user_types
 * @property array $doctors
 * @property array $users
 * @property int $id
 * @property string|null $title
 * @property string|null $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AdminNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminNotification whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminNotification whereDoctors($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminNotification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminNotification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminNotification whereUserTypes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminNotification whereUsers($value)
 * @mixin \Eloquent
 * @mixin IdeHelperAdminNotification
 */
class AdminNotification extends Model
{
    const USER_TYPE_DOCTOR = 1;
    const USER_TYPE_PATIENT = 0;
    use HasFactory;
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::booted();
        static::created(function ($notification) {
            $message = CloudMessage::new()->withNotification(
                Notification::create($notification->title, $notification->body, $notification->file_url),
            );
            /** @var \Illuminate\Support\Collection $tokens */
            $tokens = Device::ofDoctors($notification->doctors ?? [])
                ->pluck('token')
                ->concat(Device::ofUsers($notification->users ?? [])->pluck('token'),)
                ->unique();
            
            if ($tokens->isNotEmpty()) {
                app('firebase.messaging')->sendMulticast(
                    $message,
                    $tokens->toArray(),
                );
            }
        });
    }
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'doctors' => 'array',
        'users' => 'array',
    ];
}
