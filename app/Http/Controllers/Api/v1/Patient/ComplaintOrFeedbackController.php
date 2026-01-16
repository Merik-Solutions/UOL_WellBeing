<?php

namespace App\Http\Controllers\Api\v1\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\ComplaintOrFeedbackRequest;
use App\Http\Resources\Complaint\DisputedResource;
use App\Models\ComplaintOrFeedback;
use App\Models\Patient;
use App\Models\Reservation;
use App\Models\UserDoctorPackage;
use App\Repositories\SQL\AdminNotificationRepositoryEloquent;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ComplaintOrFeedbackController extends Controller
{
    protected $repo;

    public function addComplaintOrFeedback(ComplaintOrFeedbackRequest $request, AdminNotificationRepositoryEloquent $repo)
    {
        $this->repo = $repo;
        try {
            $type = ucfirst($request->type);
            DB::beginTransaction();
            if($request->disputed_type == ComplaintOrFeedback::PACKAGE){
                $disputable = UserDoctorPackage::find($request->disputed_id);               
            }else{
                $disputable = Reservation::find($request->disputed_id);
            }
            
            if ($request->disputed_id) {                
                $ComplaintOrFeedback = ComplaintOrFeedback::where('disputed_id', $request->disputed_id)
                    ->where('patient_id', $request->patient_id)->where('doctor_id', $disputable->doctor_id)
                    ->first();
                if ($ComplaintOrFeedback) {
                    DB::rollBack();
                    return responseJson(
                        null,
                        __($type . ' already registered'),
                    );
                } else {
                    if($request->disputed_type == ComplaintOrFeedback::PACKAGE){
                        $disputable->status = UserDoctorPackage::PACKAGE_DISPUTED;
                    }else{
                        $disputable->reservation_status = Reservation::RESERVATION_DISPUTED;
                    }
                    $disputable->save();
                }
            }
            ComplaintOrFeedback::create([
                'patient_id' => $request->patient_id ?? $disputable->patient_id,
                'doctor_id' => $disputable->doctor_id ?? $request->doctor_id ?? null,
                'disputed_id' => $request->disputed_id ?? null,
                'disputed_type' => $request->disputed_type ?? null,
                'type' => strtolower($request->type ?? 'feedback'),
                'description' => $request->description,
            ]);

            $notify_data =[
                'title' => "Reservation Disputed",
                'body' => "Remarks added By patient to your disputed reservation number:{$disputable->id}",
                'user_types' => "0",
                'doctors' => [$disputable->doctor_id],
                'users' => null,
            ];
            $notification = $this->repo->create($notify_data);

            DB::commit();

            return responseJson(
                null,
                __($type . ' registered.'),
            );
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('Complaint registration failed error__________');
            Log::info($e->getMessage());
            return responseJson(
                null,
                __($type . ' registration failed.'),
            );
        }
    }

    public function getDisputedAppointment(Request $request)
    {

        $disputed = ComplaintOrFeedback::with(
            [
                'remarks_history',                
                'reservation.transaction',
                'messagePackage.transaction',                
                'doctor' => function ($query) {
                    $query->select('name_en');
                },
            ]
        )->where('patient_id', $request->patient_id)->orderBy('updated_at', 'DESC')->get();

        return responseJson(
            ['disputed_appointment' => $disputed],
            __('Loaded successfully'),
        );
    }
}
