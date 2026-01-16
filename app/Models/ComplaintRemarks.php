<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintRemarks extends Model
{
    use HasFactory;
    public $table = 'complaint_remarks';

    protected $fillable = [
        'complaint_id','remarks','remarks_by','status'
    ];

    public function complaint()
    {
        return $this->belongsTo(ComplaintOrFeedback::class , 'complaint_id');
    }
    public function remarksBy()
    {
        return $this->belongsTo(Admin::class , 'remarks_by')->select('id','name','email');
    }
}
