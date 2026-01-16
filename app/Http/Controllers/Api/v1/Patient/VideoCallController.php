<?php

namespace App\Http\Controllers\Api\v1\Patient;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\UserDoctorCallLog;
use App\Models\VideoCallRecord;
use App\Repositories\interfaces\ReservationRepository;
use App\Services\VideoCall\Interfaces\SignatureContract;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\VideoCall\Drivers\AgoraCallRecord;
use Exception;
use Illuminate\Support\Facades\Log;

class VideoCallController extends Controller
{
    public function start(
        SignatureContract $signature,
        ReservationRepository $repo,
        Request $request,
        AgoraCallRecord $call_record,
    ) {
        $request->validate([
            'reservation_id' => [
                'required',
                'integer',
                Rule::exists('reservations', 'id'),
            ],
        ]);

        $reservation = $repo->find($request->reservation_id);
        userDoctorCallLog(Patient::class,$reservation->patient_id,$request->reservation_id,UserDoctorCallLog::CALL_ACCEPTED);
        $reservation->start('doctor', $request->link ?? '');

        $agora_uid = substr(str_replace(".","",microtime(true)), -4);
        $callRecord = VideoCallRecord::create([
            'reservation_id'=> $reservation->id,
            'signature'=> $signature->generateSignature($request->reservation_id,"agora_recorder"),
            'u_id'=> $agora_uid,
        ]);

        try {            
            $response = $call_record->recordAcquire($callRecord);
            if($response['status']){
                $callRecord->resource_id = $response['data']->resourceId;
                $callRecord->save();    
                Log::info("Aquire response {$response['data']->resourceId}");
    
                // start call recording
                $start_response = $call_record->recordStart($callRecord);
                $callRecord->s_id = $start_response['data']->sid;
                $callRecord->save();
                Log::info("Start response ");
                Log::info(print_r($start_response,true));

                // Querry api called
                $query_response = $call_record->callQuery($callRecord);    
                if(isset($query_response['data'])){
                    $callRecord->file_data = json_encode($query_response);
                    $callRecord->save();
                }
                Log::info("Query response ");
                Log::info(print_r($query_response,true));
    
            }
        } catch (Exception $e) {
            Log::info($e->getMessage());
        }
        

        return responseJson(
            [
                'singature' => $signature->generateSignature(
                    $request->reservation_id,
                    "patient"
                ),
            ],
            __('Singature Generated Successfully'),
        );
    }
    public function finish(ReservationRepository $repo, Request $request)
    {        
        $request->validate([
            'reservation_id' => [
                'required',
                'integer',
                Rule::exists('reservations', 'id'),
            ],
        ]);
        userDoctorCallLog(Patient::class,$request->patient_id,$request->reservation_id,$request->call_status);
        $repo->find($request->reservation_id)->finish('doctor');

        return responseJson(null, __('Reservation Finished Successfully'));
    }
}
