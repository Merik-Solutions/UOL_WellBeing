<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Rating
 *
 * @property int $id
 * @property int $rate
 * @property int|null $reservation_id
 * @property int $doctor_id
 * @property int $user_id
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Doctor $doctor
 * @property-read \App\Models\Reservation|null $reservation
 * @property-read \App\Models\User $user
 * @mixin IdeHelperRating
 */
class Rating extends Model
{
    use HasFactory;
    protected $fillable = [
        'rate',
        'reservation_id',
        'doctor_id',
        'user_id',
        'patient_id',
        'description',
    ];

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

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function scopeOfDoctor(Builder $builder, $doctor_id): void
    {
        $builder->where('doctor_id', $doctor_id);
    }

    public static function rules()
    {
        return [
            'reservation_id' =>
                'required|integer|exists:reservations,id,user_id,' .
                auth()->id(),
            'description' => 'nullable|string',
            'rate' => 'required|integer|min:0|max:5',
        ];
    }
}
