<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserDoctorCallLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VideoCallController extends Controller
{
    public function index(){
        $data['call_logs'] = UserDoctorCallLog::with('reservation')->groupBy('reservation_id')->get();
        return view('admin.call_logs.index',$data);

    }

    public function showCallLogs($reservation_id){
        $data['call_logs'] = UserDoctorCallLog::with('reservation')->where('reservation_id',$reservation_id)->get();
        return view('admin.call_logs.modal._call_logs',$data);       

    }
}
