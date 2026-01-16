<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Prescription
 *
 * @property int $id
 * @property int $reservation_id
 * @property int $doctor_id
 * @property int $user_id
 * @property string|null $code
 * @property string|null $diagnosis
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @mixin IdeHelperPrescription
 */
class Prescription extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reservation_id',
        'doctor_id',
        'user_id',
        'patient_id',
        'code',
        'diagnosis',
        'description',
    ];

    public function scopeOfUser(Builder $builder, $user_id): void
    {
        $builder->where('user_id', $user_id);
    }

    public function scopeOfPatient($query, $patient_id): void
    {
        $query->where('patient_id', $patient_id);
    }

    public function scopeOfDoctor(Builder $builder, $doctor_id): void
    {
        $builder->where('doctor_id', $doctor_id);
    }

    public function scopeOfReservation(Builder $builder, $reservation_id): void
    {
        $builder->where('reservation_id', $reservation_id);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(PrescripionItem::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
