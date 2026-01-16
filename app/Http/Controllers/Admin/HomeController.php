<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\WithdrawRequest;
use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Repositories\interfaces\UserRepository;
use App\Repositories\interfaces\DoctorRepository;
use App\Repositories\interfaces\CategoryRepository;
use App\Repositories\interfaces\ReservationRepository;
use App\Repositories\interfaces\TransactionRepository;
use App\Repositories\interfaces\WithdrawRequestRepository;

class HomeController extends Controller
{
    protected $redirectTo = '/admin/ar/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin.auth:admin');
    }

    /**
     * Show the Admin dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(
        UserRepository $userRepo,
        DoctorRepository $doctorRepo,
        ReservationRepository $reservationRepo,
        TransactionRepository $transactionRepo,
        WithdrawRequestRepository $withdrawRequestRepo,
    ) {
        $reservations = Reservation::whereDate(
            'date',
            '>=',
            now()->toDateString(),
        )->get();
        // dd($reservations);
        $doctor_paid = $transactionRepo
            ->whereHasMorph('sender', Admin::class)
            ->sum('amount');

        return view('admin.home', [
            'reservations_count' => $reservations->count(),
            'patients_count' => Patient::count(),
            // 'patients_count' => $userRepo->count(),
            'doctors_count' => $doctorRepo->count(),
            'duration_count' => $reservationRepo->duration(),
            'patient_paid' => number_format(
                $transactionRepo->forPatients()->sum('amount'),
                1,
            ),
            'doctor_due' => number_format($doctorRepo->get()->sum('wallet'), 1),
            'doctor_paid' => number_format($doctor_paid, 1),
            'withdraw_amount' => number_format(
                $withdrawRequestRepo
                    ->where('status', WithdrawRequest::WAITING)
                    ->sum('amount'),
                1,
            ),
            'withdraw_count' => $withdrawRequestRepo
                ->where('status', WithdrawRequest::WAITING)
                ->count(),
        ]);
    }
    public function updateStatistics(
        Request $request,
        UserRepository $userRepo,
        DoctorRepository $doctorRepo,
        ReservationRepository $reservationRepo,
        TransactionRepository $transactionRepo,
        WithdrawRequestRepository $withdrawRequestRepo,
    ) {
        return [
            'patients_count' => $userRepo
                ->creationType($request->type)
                ->count(),
            'doctors_count' => $doctorRepo
                ->creationType($request->type)
                ->count(),
            'duration_count' => $reservationRepo
                ->creationType($request->type)
                ->duration(),
            'paid_count' => $reservationRepo
                ->creationType($request->type)
                ->duration(),
            'patient_paid' => number_format(
                $transactionRepo
                    ->creationType($request->type)
                    ->forPatients()
                    ->sum('amount'),
                1,
            ),
            'doctor_due' => number_format($doctorRepo->get()->sum('wallet'), 1),

            'doctor_paid' => number_format(
                $transactionRepo
                    ->creationType($request->type)
                    ->whereHasMorph('sender', Admin::class)
                    ->sum('amount'),
                1,
            ),

            'withdraw_amount' => number_format(
                $withdrawRequestRepo
                    ->creationType($request->type)
                    ->where('status', WithdrawRequest::WAITING)
                    ->sum('amount'),
                1,
            ),
            'withdraw_count' => $withdrawRequestRepo
                ->creationType($request->type)
                ->where('status', WithdrawRequest::WAITING)
                ->count(),
        ];
    }

    public function saleReports(TransactionRepository $transactionRepo){
        $type = 'daily';
        $data['daily_sale'] = number_format($transactionRepo->creationType($type)->sum('amount'),1);
        $data['today_revenue'] = number_format($transactionRepo->creationType($type)->sum('commission'),1);
        $data['total_amount'] = number_format($transactionRepo->creationType($type)->sum('total'),1);
        $data['total_transactions'] = $transactionRepo->creationType($type)->count();
        $data['transactions'] = $transactionRepo->creationType($type)->with('sender:id,name,phone', 'receiver:id,name')->orderBy('created_at', 'DESC')->get();
        return view('admin.reports.index',$data);

    }
    public function filterReports(Request $req, TransactionRepository $transactionRepo){
        $type = $req->type ?? 'daily';
        if($req->type == 'custom'){
            $start_date = $req->start_date;
            $end_date = $req->end_date;
            $data['daily_sale'] = number_format($transactionRepo->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->sum('amount'),1);
            $data['today_revenue'] = number_format($transactionRepo->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->sum('commission'),1);
            $data['total_amount'] = number_format($transactionRepo->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->sum('total'),1);
            $data['total_transactions'] = $transactionRepo->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->count();
            $data['transactions'] = $transactionRepo->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)
                ->with('sender:id,name,phone', 'receiver:id,name')->orderBy('created_at', 'DESC')->get();
        }else{
            $data['daily_sale'] = number_format($transactionRepo->creationType($type)->sum('amount'),1);
            $data['today_revenue'] = number_format($transactionRepo->creationType($type)->sum('commission'),1);
            $data['total_amount'] = number_format($transactionRepo->creationType($type)->sum('total'),1);
            $data['total_transactions'] = $transactionRepo->creationType($type)->count();
            $data['transactions'] = $transactionRepo->creationType($type)->with('sender:id,name,phone', 'receiver:id,name')->orderBy('created_at', 'DESC')->get();
        }

        $view =  view('admin.reports.data_file',$data)->render();
        return response()->json(['status' =>true, 'message' => 'Data Loaded.', 'html' => $view]);
    }
    
}
