<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserDoctorPackage;
use Illuminate\Http\Request;
use App\Models\ComplaintOrFeedback;
use App\Models\Patient;
use App\Models\Reservation;
use App\Repositories\SQL\AdminNotificationRepositoryEloquent;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Support\Facades\Auth;
class MessagePackageController extends Controller
{
    protected $repo;

    public function index(){
        $data['packages'] = UserDoctorPackage::with('latestMessage')->MessageCount()->orderBy('id','DESC')->get();
        $data['active_packages'] = UserDoctorPackage::with('latestMessage')->MessageCount()->where('expired_at','>',Carbon::now())->orderBy('id','DESC')->get();
        $data['expired_packages'] = UserDoctorPackage::with('latestMessage')->MessageCount()->where('expired_at','<',Carbon::now())->orderBy('id','DESC')->get();
        // dd($data['packages']);
    
        return view('admin.message_packages.index',$data);

    }

    public function add_message_dispute(Request $request, AdminNotificationRepositoryEloquent $repo)
    {
        $this->repo = $repo;
        try {
            DB::beginTransaction();
            $package = UserDoctorPackage::find($request->package_id);
            $patient = Patient::find($package->patient_id);
            $package->status = UserDoctorPackage::PACKAGE_DISPUTED;        
            $package->save();
            
            $notify_data =[
                'title' => "Reservation Disputed",
                'body' => "This message package has been marked as disputed By Kindahealth package number:{$package->id}",
                'user_types' => "0",
                'doctors' => [$package->doctor_id],
                'users' => [$patient->user_id]
            ];

            $complaint = ComplaintOrFeedback::create([
                'patient_id' => (int)$package->patient_id,
                'doctor_id' => $package->doctor_id,
                'disputed_id' => $package->id,
                'disputed_type' => ComplaintOrFeedback::PACKAGE,
                'type' => ComplaintOrFeedback::COMPLAINT,
                'description' => $request->reason,
                'remarks' => $request->remarks,
                'remarks_by' => Auth::user()->id,
                'status' => ComplaintOrFeedback::STATUS_PENDING,

            ]);
            $notification = $this->repo->create($notify_data);     
            DB::commit();            
            return response()->json(['message' => 'Package marked as disputed'],200);
        }catch( Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()],419);
        }
    }

    public function show_package_detail($id){

            $data['package'] = UserDoctorPackage::with(
                'doctor:id,name_en,name_ar,company_name',
                'patient:id,name,user_id,relation',
                'complaint_feedback.remarks_history'
                )->find($id);
            return view('admin.payments.modals.package_detail',$data);
        

    }
}
