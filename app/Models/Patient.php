<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_ar',
        'email',
        'birthdate',
        'gender',
        'image',
        'relation',
        'user_id',
        'national_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // public function reservation_doctor()
    // {
    //     return $this->belongsToMany(
    //         Doctor::class,
    //         'reservations',
    //         'patient_id',
    //         'doctor_id',
    //     );
    // }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'name_ar' => ['nullable', 'string'],
            'national_id' => ['required', 'digits:10'],
            'email' => [
                'required',
                'email:rfc,dns,spoof',
                'unique:users,email,' . $this->id,
            ],
            'relation' => ['required', 'string'],
            // 'phone' => [
            //     'required',
            //     'string',
            //     'unique:users,phone,' . $this->id,
            //     'phone:AE,EG,SA,BH',
            //     'regex:/^([0-9+])+$/',
            //     'regex:/^[+]/',
            // ],
            // 'password' => ['nullable', 'string', 'confirmed'],
            'birthdate' => ['required', 'date', 'date_format:Y-m-d'],
            'gender' => ['required', 'boolean'],
            'image' => ['nullable', 'image'],
            'national_id' => ['nullable'],
        ];
    }

    public function getMedicalHistoryAttribute(): string
    {
        return $this->id;
    }

    public function getImageAttribute()
    {
        return fileUrl($this->attributes['image'] ?? avatar());
    }
}
