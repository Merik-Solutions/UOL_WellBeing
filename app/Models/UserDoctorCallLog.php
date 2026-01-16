<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDoctorCallLog extends Model
{
    use HasFactory;

    protected $table = 'user_doctor_call_logs';

    const CALL_START = 'call_start';
    const CALL_MISSED = 'call_missed';
    const CALL_ACCEPTED = 'call_accepted';
    const CALL_REJECTED = 'call_rejected';
    const CALL_END = 'call_end';

    protected $fillable = [
        'reservation_id',
        'date',
        'time',
        'initiator',
        'initiator_id',
        'status',
        
    ];

    protected static function booted()
    {
        parent::booted();
        UserDoctorCallLog::creating(function($model) {           
            $model->date = Carbon::now()->format('Y-m-d');
            $model->time = Carbon::now()->format('H:i:s');
        });
    }


    public function reservation(){
        return $this->belongsTo(Reservation::class);
    }
    
    public function doctor(){
        return $this->belongsTo(Doctor::class,'initiator_id');
    }

    public function patient(){
        return $this->belongsTo(Patient::class,'initiator_id');
    }

    public function scopeIsDoctor($query){
        return $query->where('initiator',Doctor::class);
    }
    public function scopeIsPatient($query){
        return $query->where('initiator',Patient::class);
    }

    
}
