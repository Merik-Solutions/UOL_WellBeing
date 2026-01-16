<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Patient;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Reservation\ReservationResource;
use App\Models\ComplaintOrFeedback;
use App\Repositories\interfaces\ReservationRepository;
use App\Repositories\SQL\AdminNotificationRepositoryEloquent;
use App\Services\VideoCall\Drivers\AgoraCallRecord;
use Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Js;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Throwable;
use Storage;

class ReservationController extends Controller
{
    protected $routeName = 'admin.refunds';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $repo;

     function __construct(ReservationRepository $repo)
     {
        $this->repo = $repo;

         $this->middleware('permission:show-reservations')->only('index','show');
     
     }
 

    public function index()
    {        
        $query['reservations'] = Reservation::all();
        $query['todays_reservations'] = Reservation::with('reservationCallLog')->whereDate('date','=',Carbon::now())->orderBy('id', 'DESC')->get();
        $query['active_reservations'] = Reservation::with('reservationCallLog')->where('status','active')->whereDate('date','>=',Carbon::now())->orderBy('id', 'DESC')->get();
        $query['no_show_reservations'] = Reservation::with('reservationCallLog')->where('status','active')->whereDate('date','<',Carbon::now())->orderBy('id', 'DESC')->get();
        $query['accepted_reservations'] = Reservation::with('reservationCallLog')->where('status','on_call')->orderBy('id', 'DESC')->get();
        $query['canceled_reservations'] = Reservation::with('reservationCallLog')->where('status','cancled')->orderBy('id', 'DESC')->get();
        $query['finished_reservations'] = Reservation::with('reservationCallLog','videoCallRecord')->where('status','finished')->orderBy('id', 'DESC')->get();

        return view('admin.reservations.index', $query);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function reservation_cancel_byAdmin($patient_id,$reservation_id)
    {
        try{
            $reservation = $this->repo->cancel($reservation_id);
            return response()->json([
                'error' => false,
                'message' => 'Reservation canceled',
            ]);
        }catch(Throwable $e){
            Log::info('Reservation cancellation failed error_____');
            Log::info($e->getMessage());
            return response()->json([
                'error' => true,
                'message' => 'Reservation cancellation failed!.',
            ]);
        }
        
        

        $reservation = Reservation::where('patient_id',$patient_id)->first();
        $patient = Patient::find($reservation->patient_id);
        // dd($patient);
        $user = User::find($patient->user_id);
        $token = JWTAuth::fromUser($user);

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://kindahealth.com/api/v1/patient/reservations/cancel',
        // CURLOPT_URL => 'http://kareem.com/eldoctor_web/public/api/v1/patient/reservations/cancel',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "patient_id": '.$patient_id.',
            "reservation_id": '.$reservation_id.'
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Bearer'.$token,
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $query['message']= json_decode($response);
        toast($query['message']->message, 'success');

        // return view('admin.transactions.refund_requests',$query);

        return redirect()->route($this->routeName);

    }

    public function get_reservation_detail(Request $request){

        $data['reservation'] = Reservation::where('id',$request->reservation_id)->with('doctor','patient.user')->first();    
        return view('admin.reservations.reservation_modal',$data);
    }

    public function show_reservation_detail($id){
        $data['reservation'] = Reservation::with(
            'doctor:id,name_en,name_ar,company_name',
            'patient:id,name,user_id,relation',
            'complaint_feedback.remarks_history'
            )->find($id);
        return view('admin.payments.modals.reservation_detail',$data);
    }


    public function addDispute(Request $request, AdminNotificationRepositoryEloquent $repo){
        $this->repo = $repo;
        try {
            DB::beginTransaction();
            $reservation = Reservation::find($request->reservation_id);
            $patient = Patient::find($reservation->patient_id);

            $notify_data =[
                'title' => "Reservation Disputed",
                'body' => "This reservation has been marked as disputed By Kindahealth reservation number:{$reservation->id}",
                'user_types' => "0",
                'doctors' => [$reservation->doctor_id],
                'users' => [$patient->user_id]
            ];
                    

            $reservation->reservation_status = Reservation::RESERVATION_DISPUTED;        
            $reservation->save();           

            $complaint = ComplaintOrFeedback::create([
                'patient_id' => (int)$reservation->patient_id,
                'doctor_id' => $reservation->doctor_id,
                'disputed_id' => $reservation->id,
                'disputed_type' => ComplaintOrFeedback::RESERVATION,
                'type' => ComplaintOrFeedback::COMPLAINT,
                'description' => $request->reason,
                'remarks' => $request->remarks,
                'remarks_by' => Auth::user()->id,
                'status' => ComplaintOrFeedback::STATUS_PENDING,

            ]);
            $notification = $this->repo->create($notify_data);           
            DB::commit();            
            return response()->json(['message' => 'Reservation marked as disputed'],200);
        }catch( Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()],419);
        }
        
    }

    public function getCallRecording($res_id,AgoraCallRecord $call_record)
    {
        $data['reservation'] = $this->repo
            ->with('videoCallRecord','doctor:id,name_en,name_ar,company_name','patient:id,name,phone,user_id,relation')
            ->find($res_id);
        // $recording = $data['reservation']->videoCallRecord[0]??null;
        
        $allFiles = Storage::disk('s3')->files($res_id);
        $data['videos'] = [];
        foreach($allFiles as $video){
            if(strpos($video,'.mp4')== true){
                array_push($data['videos'],$video);
            }
        }        

        // $file_data = isset($recording) ? json_decode($recording->file_data??''):null;
        // $resource_id = $file_data?->data?->resourceId??null; 
        // $sid = $file_data?->data?->sid??null;


        // $r = $call_record->getCallRecord($resource_id,$sid);
        // dd($r);

        return view('admin.reservations.modals.call_recording',$data);
    }
}
