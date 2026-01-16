<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;

class ComplaintOrFeedback extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'complaint_or_feedback';

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'disputed_id',
        'disputed_type',
        'type',
        'description',
        'remarks',
        'remarks_by',
        'status'
    ];

    const COMPLAINT = 'complaint';
    const FEEDBACK = 'feedback';
    const PACKAGE = 'package';
    const RESERVATION = 'reservation';

    const STATUS_PENDING = 'pending';
    const STATUS_RESOLVED = 'resolved';
    const STATUS_INVESTIGATE = 'under-investigation';

    function patient(){
        return $this->belongsTo(Patient::class,'patient_id');
    }

    function remarks_history(){
        return $this->hasMany(ComplaintRemarks::class,'complaint_id')->orderBy('created_at','DESC');
    }

    function remarksBy(){
        return $this->belongsTo(Admin::class,'remarks_by');
    }
    
    function doctor(){
        return $this->belongsTo(Doctor::class,'doctor_id');
    }

    function reservation(){
        return $this->belongsTo(Reservation::class,'disputed_id');
    }
    
    function messagePackage()
    {        
        return $this->belongsTo(UserDoctorPackage::class, 'disputed_id');
       
    }

}
