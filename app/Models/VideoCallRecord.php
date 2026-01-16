<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoCallRecord extends Model
{
    use HasFactory;

    protected $table = "video_call_recordings";

    protected $fillable = [
        'reservation_id',
        's_id',
        'u_id',
        'resource_id',
        'file_name',
        'file_url',
        'signature',       
        'file_data',       
    ];


    public function reservation(){
        return $this->belongsTo(Reservation::class);
    }
}
