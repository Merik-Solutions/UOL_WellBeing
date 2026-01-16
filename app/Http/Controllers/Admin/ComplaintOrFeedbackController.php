<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ComplaintOrFeedback;
use App\Models\ComplaintRemarks;
use App\Models\Patient;
use App\Models\Reservation;
use App\Models\UserDoctorPackage;
use App\Repositories\SQL\AdminNotificationRepositoryEloquent;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ComplaintOrFeedbackController extends Controller
{
    protected $repo;

    public function index()
    {
        $data['all_disputes'] = ComplaintOrFeedback::with(['doctor','patient','reservation'])->get();
        $data['pending'] = ComplaintOrFeedback::with(['doctor','patient','reservation'])->where('status', ComplaintOrFeedback::STATUS_PENDING)->get();
        $data['investigation'] = ComplaintOrFeedback::with(['doctor','patient','reservation'])->where('status', ComplaintOrFeedback::STATUS_INVESTIGATE)->get();
        $data['resolved'] = ComplaintOrFeedback::with(['doctor','patient','reservation'])->where('status', ComplaintOrFeedback::STATUS_RESOLVED)->get();
        
        return view('admin.dispute_center.index',$data);
    }

    public function resDetail($id)
    {
        $data['resDetail'] = ComplaintOrFeedback::with(
            [
                'remarks_history.remarksBy',
                'reservation',
                'messagePackage.package',
                'doctor:id,name_en,name_ar,company_name',
                'patient:id,name,user_id,relation',
                'remarksBy:id,name'
            ])->find($id);

        return view('admin.dispute_center.modal._dispute_detail',$data);
        
    }

    public function addComplaintOrFeedbackRemarks(Request $request, AdminNotificationRepositoryEloquent $repo){

        $this->repo = $repo;
        try {
            DB::beginTransaction();
            $complaint = ComplaintOrFeedback::find($request->complaint_id);

            $remarks = new ComplaintRemarks();
            $remarks->complaint_id = $complaint->id;
            $remarks->remarks = $complaint->remarks ?? '';
            $remarks->remarks_by = Auth::user()->id;
            $remarks->status = $complaint->status;
            $remarks->save();

            $complaint->status = strtolower($request->status ?? 'pending');
            $complaint->remarks = $request->remarks;
            $complaint->remarks_by = Auth::user()->id;
            $complaint->save();
            if($request->disputed_type == ComplaintOrFeedback::PACKAGE){
                $disputable = UserDoctorPackage::find($complaint->disputed_id);
            }else{
                $disputable = Reservation::find($complaint->disputed_id);
            }
            if($disputable){
                if(strtolower($request->status) == ComplaintOrFeedback::STATUS_RESOLVED){          
                    if($request->disputed_type == ComplaintOrFeedback::PACKAGE){
                        $disputable->status = UserDoctorPackage::PACKAGE_PENDING;
                    }else{
                        $disputable->reservation_status = Reservation::RESERVATION_PENDING;
                    }
                    if($request->penalty && $request->penalty != 0){
                        $disputable->penalty_percent = $request->penalty;
                        $disputable->price_before_penalty =$disputable->price;
                        $disputable->price = penalizeDoctor($request->penalty,$disputable->price);
                    }
                    
                    $remarks = new ComplaintRemarks();
                    $remarks->complaint_id = $complaint->id;
                    $remarks->remarks = $request->remarks;
                    $remarks->remarks_by = Auth::user()->id;
                    $remarks->status = ComplaintOrFeedback::STATUS_RESOLVED;
                    $remarks->save();

                } else {
                    if($request->disputed_type == ComplaintOrFeedback::PACKAGE){
                        $disputable->status = UserDoctorPackage::PACKAGE_DISPUTED;
                    }else{
                        $disputable->reservation_status = Reservation::RESERVATION_DISPUTED;
                    }
                }
                $disputable->save();
            }

            $patient = Patient::find($disputable->patient_id);
            $notify_data =[
                'title' => "Reservation Disputed",
                'body' => "Remarks added By Kindahealth to your disputed reservation number:{$disputable->id}",
                'user_types' => "0",
                'doctors' => [$disputable->doctor_id],
                'users' => [$patient->user_id]
            ];

            $notification = $this->repo->create($notify_data);


            DB::commit();            
            return response()->json(['message' => 'Remarks added successfully.','error' => false]);
        }catch( Exception $e){
            DB::rollBack();
            Log::info('Add dispute remarks error________');
            Log::info($e->getMessage());
            return response()->json(['message' => 'Failed to add remarks.','error' => true]);
        }
    }

    
}
