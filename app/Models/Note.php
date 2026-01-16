<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Note
 *
 * @property $user_id
 * @property $doctor_id
 * @property $title
 * @property $description
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Doctor $doctor
 * @property-read \App\Models\User $user
 * @mixin IdeHelperNote
 */
class Note extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

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
        return $this->belongsTo(Patient::class)->withDefault(new Patient());
    }

    /**
     * Scope a query to only include doctor_id
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeOfDoctor($query, $doctor_id): void
    {
        $query->where('doctor_id', $doctor_id);
    }

    /**
     * Scope a query to only include user_id
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeOfUser($query, $user_id): void
    {
        $query->where('user_id', $user_id);
    }

    public function scopeOfPatient($query, $patient_id): void
    {
        $query->where('patient_id', $patient_id);
    }

    public function rules(): array
    {
        return [
            //            'user_id' => ['required', 'integer', 'exists:users,id'],
            'patient_id' => ['required', 'integer', 'exists:patients,id'],
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'diagnosis' => ['required', 'string'],
            'allergy' => ['nullable', 'string'],
        ];
    }
}
