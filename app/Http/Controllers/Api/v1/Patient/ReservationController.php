<?php

namespace App\Http\Controllers\Api\v1\Patient;

use App\Criteria\OfPatientCriteria;
use App\Http\Controllers\Controller;
use App\Http\Middleware\ShouldHavePatientId;
use App\Http\Requests\Reservation\CancleReservationRequest;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Reservation\StoreReservationRequest;
use App\Http\Resources\Reservation\ReservationInvoiceResource;
use App\Http\Resources\Reservation\ReservationResource;
use App\Models\Patient;
use App\Models\Reservation;
use App\Models\UserDoctorPackage;
use App\Repositories\interfaces\ReservationRepository;
use App\Repositories\SQL\AdminNotificationRepositoryEloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use MyFatoorah\Library\PaymentMyfatoorahApiV2;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ReservationController extends Controller
{
    private $repo;
    protected $notify_repo;

    public function __construct(ReservationRepository $repo)
    {
        $this->middleware(ShouldHavePatientId::class)->except('show');
        $this->repo = $repo->pushCriteria(
            new OfPatientCriteria(request()->patient_id ?? auth('api')->id()),
        );
        // dd(auth('api')->id());
    }

    public function create(StoreReservationRequest $request)
    {
        DB::beginTransaction();
        $data = $request->validated();
        /** @var \App\Models\Reservation $reservation */
        $reservation = $this->repo->create($data);
        /**@var \App\Models\User $user */
        $request->validatePaidAmountShouldEqualReservationPrice($data['price']);
        // $request->validateUserWalletHasTheDeductedAmount();
        // if ($request->input('wallet') != 0) {
            // $reservation->payWallet();
        // }
        // if ($request->input('online') != 0) {
            $reservation->payOnline();
        // }
        // $reservation->pay();
        $reservation->load('transactions');
        DB::commit();
        $this->reservationInvoiceMail($reservation->id);
        return responseJson(
            new ReservationResource($reservation),
            __('Saved and invoice will be Emailed.'),
        );
    }

    public function cancel(CancleReservationRequest $request)
    {
        $reservation = $this->repo->cancel($request->reservation_id);

        return responseJson(
            ['reservation' => new ReservationResource($reservation)],
            __('Canceled Successfully'),
        );
    }
    /**
     * @param Request $request
     * @return \App\Helpers\Responder
     */
    public function upcoming()
    {
        $reservation = QueryBuilder::for(Reservation::class)
            ->allowedFilters([
                AllowedFilter::exact('doctor_id'),
                AllowedFilter::exact('promocode_id'),
                AllowedFilter::exact('price'),
                AllowedFilter::exact('date'),
                AllowedFilter::exact('status'),
                'description',
            ])
            ->allowedSorts(['date'])
            ->ofPatient(request('patient_id'))
            ->with('doctor', 'pending_request')
            // ->orderBy('date', 'asc')
            ->defaultSort('date')

            // ->whereNotIn('status', [
            //     Reservation::STATUS_CANCLED,
            //     Reservation::STATUS_FINISHED,
            // ])
            ->upcoming()
            ->paginate(10);

        return responseJson(
            ReservationResource::collection($reservation),
            __('Loaded Successfully'),
        );
    }

    /**
     * @return \App\Helpers\Responder
     */
    public function previous()
    {
        $reservation = QueryBuilder::for(Reservation::class)
            ->allowedFilters([
                AllowedFilter::exact('doctor_id'),
                AllowedFilter::exact('promocode_id'),
                AllowedFilter::exact('price'),
                AllowedFilter::exact('date'),
                AllowedFilter::exact('status'),
                'description',
            ])
            ->allowedSorts(['date'])
            ->with('doctor')
            ->ofpatient(request('patient_id'))
            ->previous()
            ->withCount('prescription', 'rating')
            ->defaultSort('-date')
            ->paginate(10);
        return responseJson(
            ReservationResource::collection($reservation),
            __('Loaded Successfully'),
        );
    }

    public function show($reservation_id)
    {
        $reservation = $this->repo->with('doctor')->find($reservation_id);

        return responseJson(
            new ReservationResource($reservation),
            __('Loaded successfully'),
        );
    }
    public function makeAppointmentDisputed(Request $request, AdminNotificationRepositoryEloquent $notify_repo)
    {    
        $this->notify_repo = $notify_repo;
        $reservation = Reservation::find($request->reservation_id);
        $reservation->reservation_status = Reservation::RESERVATION_DISPUTED;

         $doctor_data =[
            'title' => "Reservation Disputed",
            'body' => "{$reservation->patient->name_en} marked reservation as a disputed ID={$reservation->id}",
            'user_types' => "1",
            'doctors' => [$reservation->doctor_id],
        ];

        $notification = $this->notify_repo->create($doctor_data);

        return responseJson(
           null,
            __('Reservation Marked as disputed'),
        );
    }

    public function getPatientReservation(Request $request){
        $data['reservation'] = Reservation::where('patient_id', $request->patient_id)
        ->where('reservation_status','!=',Reservation::RESERVATION_DISPUTED)->get();
        $data['packages'] = UserDoctorPackage::where('patient_id', $request->patient_id)
                        ->where('status','!=',UserDoctorPackage::PACKAGE_DISPUTED)->get();

        return responseJson($data);
    }

    public function reservationInvoiceMail($res_id){
        $reservation= Reservation::with([
            'doctor:id,name_en,name_ar,email',
            'Patient:id,name,national_id,email',
            'doctor.category',
            'transaction',
            'promocode'
            ])->find($res_id);
        $data['reservation'] = $reservation;
        $data['email'] = $reservation->patient->email;
        $data['patient_name'] = $reservation->patient?->name ?? '';
        $data['title'] = 'Reservation appointment';
        set_time_limit(300);
        $pdf = \PDF::loadHTML(
            view('emails.reservation_invoice', $data)->render(),
        );
        $pdf = $pdf->setOption('page-width', '100')->setPaper('b4');    
        // return $pdf->inline("kindaHealth_reservation_invoice.pdf");

        try {
            Mail::send('emails.invoice', $data, function($message)use($data,$pdf) {
                $message->to($data["email"], $data["patient_name"])
                ->subject("KindaHealth Reservation Invoice")
                ->attachData($pdf->output(), "kindahealth_invoice.pdf");
                });

        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
    }

    public function getInvoiceData($res_id=null){
        $reservation= Reservation::with([
            'doctor:id,name_en,name_ar,email',
            'Patient:id,name,national_id,email',
            'doctor.category',
            'transaction',
            'promocode'
            ])->find($res_id);
        return responseJson(
            new ReservationInvoiceResource($reservation),
            __('Data loaded Successfully'),
        );

    }
}
