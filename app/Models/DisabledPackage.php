<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class DisabledPackage extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'disabled_packages';

    protected $fillable = [
        'package_id',
        'doctor_id',
    ];


    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
