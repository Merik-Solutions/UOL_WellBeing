<?php

namespace App\Models;

use App\Notifications\SendVerificationCode;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\VerficationCode
 *
 * @property int $id
 * @property string $verifiable_type
 * @property int $verifiable_id
 * @property string $code
 * @property string $expired_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read Model|\Eloquent $user
 * @mixin IdeHelperVerficationCode
 */
class VerficationCode extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['code', 'expired_at'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->expired_at = Carbon::now()->addDay();
        });
        // static::created(function ($model) {
        //     $model->user->notify(new SendVerificationCode($model->code));
        // });
    }

    public function user()
    {
        return $this->morphTo('verifiable');
    }
    public function scopeIsValid(Builder $query): void
    {
        $query->where('expired_at', '>=', Carbon::now());
    }
}
