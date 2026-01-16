<?php

namespace App\Http\Controllers\Api\v1\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\UserDoctorCallLog;
use App\Models\VideoCallRecord;
use App\Repositories\interfaces\ReservationRepository;
use App\Services\VideoCall\Drivers\AgoraCallRecord;
use App\Services\VideoCall\Interfaces\SignatureContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class VideoCallController extends Controller
{
    public function start(
        SignatureContract $signature,
        ReservationRepository $repo,
        Request $request,
    ) {
        $request->validate([
            'reservation_id' => [
                'required',
                'integer',
                Rule::exists('reservations', 'id')->where(
                    'doctor_id',
                    auth()->id(),
                ),
            ],
        ]);
        userDoctorCallLog(Doctor::class,auth()->id(),$request->reservation_id,UserDoctorCallLog::CALL_START);
        $repo
            ->find($request->reservation_id)
            ->start('user', $request->link ?? '');

        return responseJson(
            [
                'singature' => $signature->generateSignature(
                    $request->reservation_id,
                    "doctor"
                ),
            ],
            __('Singature Generated Successfully'),
        );
    }
    public function finish(ReservationRepository $repo, Request $request, AgoraCallRecord $call_record)
    {
        $callRecord = VideoCallRecord::where('reservation_id',$request->reservation_id)->latest()->first();
        if($callRecord){
            $response = $call_record->recordStop($callRecord);
            Log::info("Agora Stop API Response ");
            Log::info(print_r($response,true));
        }

        $request->validate([
            'reservation_id' => [
                'required',
                'integer',
                Rule::exists('reservations', 'id')->where(
                    'doctor_id',
                    auth()->id(),
                ),
            ],
        ]);
        userDoctorCallLog(Doctor::class,auth()->id(),$request->reservation_id,$request?->call_status);
        $repo->find($request->reservation_id)->finish('user');

        return responseJson(null, __('Reservation Finished Successfully'));
    }
}
