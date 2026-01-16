<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Reservation;
use App\Models\Transaction;
use App\Models\UserDoctorPackage;
use App\Models\WithdrawRequest;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    protected $project_date = '2020-01-01';

    public function index()
    {
        $data['pending'] = Doctor::with(["reservationPayable" => function ($query) {
            return $query->where('reservation_status', '=', Reservation::RESERVATION_PENDING);
        }])->with(["penalizeReservationPayable" =>function ($query) {
            return $query->where('reservation_status', '=', Reservation::RESERVATION_PENDING);
        }])->with(["packagePayable" => function ($query) {
            return $query->where('status', '=', UserDoctorPackage::PACKAGE_PENDING);
        }])->with(["penalizePackagePayable" => function ($query) {
            return $query->where('status', '=', UserDoctorPackage::PACKAGE_PENDING);
        }])->get();

        $data['disputed'] = Doctor::with(["reservationPayable" =>  function ($query) {
            return $query ->where('reservation_status', '=', Reservation::RESERVATION_DISPUTED);
        }])->with(["packagePayable" => function ($query) {
            return $query->where('status', '=', UserDoctorPackage::PACKAGE_DISPUTED);
        }])->get();


        $data['confirmed'] = Doctor::with(["paidReservations.withDraw", "paidPackages.withDraw"])->get();

        return view('admin.payments.index', $data);
    }

    public function doctor_payment_details(Request $request, $doctor_id, $status)
    {
        $isPaid = $status == 'paid';
        $data['payments'] = Doctor::with(["reservation.withDraw", "reservation" => function ($query) use ($isPaid, $status, $request) {
                $query->where('isPaid', $isPaid)
                    ->where('reservation_status', '=', $status);
                if ($request->has('withdraw_id') && $status == 'paid') {
                    $query = $query->where('withdraw_id', $request->withdraw_id);
                }
                return $query;
            }])->with(["userDoctorPackage.withDraw", "userDoctorPackage" => function ($query) use ($isPaid, $status, $request) {
                $query = $query->where('isPaid', $isPaid)->where('status', '=', $status);
                if ($request->has('withdraw_id') && $request->withdraw_id !== 'undefined') {
                    $query = $query->where('withdraw_id', $request->withdraw_id);
                }
                return $query;
            }])->find($doctor_id);

        $data['status'] = $status;

        return view('admin.payments.payment_detail', $data);
    }

    public function filterPayments(Request $request)
    {
        $filter  = $request->filter;
        $start_date = null;
        $end_date = null;

        if ($filter == 'All') {
            $data['pending'] = Doctor::with(["reservationPayable" => function ($query) {
                return $query->where('reservation_status', '=', Reservation::RESERVATION_PENDING);
            }])->with(["penalizeReservationPayable" =>function ($query) {
                return $query->where('reservation_status', '=', Reservation::RESERVATION_PENDING);
            }])->with(["packagePayable" => function ($query) {
                return $query->where('status', '=', UserDoctorPackage::PACKAGE_PENDING);
            }])->with(["penalizePackagePayable" => function ($query) {
                return $query->where('status', '=', UserDoctorPackage::PACKAGE_PENDING);
            }])->get();

            $data['disputed'] = Doctor::with(["reservationPayable" =>  function ($query) {
                return $query->where('reservation_status', '=', Reservation::RESERVATION_DISPUTED);
            }])->with(["packagePayable" => function ($query) {
                return $query->where('status', UserDoctorPackage::PACKAGE_DISPUTED);
            }])->get();

            $data['confirmed'] = Doctor::with(["paidReservations.withDraw", "paidPackages.withDraw"])->get();
        } else {

            if ($request->filter == 'custom') {
                $start_date = $request->start_date;
                $end_date = $request->end_date;
            }

            $data['pending'] = Doctor::with(["reservationPayable" => function ($query) use ($filter, $start_date, $end_date) {
                $query->where('reservation_status', '=', Reservation::RESERVATION_PENDING);
                $query = $this->filterResult($filter, $start_date, $end_date, $query);
                return $query;
            }])->with(["packagePayable" => function ($query) use ($filter, $start_date, $end_date) {
                $query->where('status', '=', UserDoctorPackage::PACKAGE_PENDING);
                $query = $this->filterResult($filter, $start_date, $end_date, $query);
                return $query;
            }])->get();

            $data['disputed'] = Doctor::with(["reservationPayable" =>  function ($query) use ($filter, $start_date, $end_date) {
                $query->where('reservation_status', '=', Reservation::RESERVATION_DISPUTED);
                $query = $this->filterResult($filter, $start_date, $end_date, $query);
                return $query;
            }])->with(["packagePayable" => function ($query) use ($filter, $start_date, $end_date) {
                $query->where('status', '=', UserDoctorPackage::PACKAGE_DISPUTED);
                $query = $this->filterResult($filter, $start_date, $end_date, $query);
                return $query;
            }])->get();

            $data['confirmed'] = Doctor::with([
                "paidReservations.withDraw" => function ($query) use ($filter, $start_date, $end_date) {
                    $query = $this->filterResult($filter, $start_date, $end_date, $query);
                    return $query;
                },
                "paidPackages.withDraw" => function ($query) use ($filter, $start_date, $end_date) {
                    $query = $this->filterResult($filter, $start_date, $end_date, $query);
                    return $query;
                }
            ])->get();
        }


        return view('admin.payments.filtered_payments', $data);
    }

    private function filterResult($filter, $start_date, $end_date, $query)
    {
        if ($filter == 'monthly') {
            $query = $query->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year);
        } elseif ($filter == 'weekly') {
            $query = $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } else {
            $query->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date);
        }
    }

    public function show_payment_modal(Request $request, $id)
    {
        $filter  = $request->filter;
        $start_date = null;
        $end_date = null;

        if ($filter == 'All') {

            $data['payment'] = Doctor::with(["reservationPayable" => function ($query) {
                return $query->where('reservation_status', '=', Reservation::RESERVATION_PENDING);
            }])->with(["penalizeReservationPayable" =>function ($query) {
                return $query->where('reservation_status', '=', Reservation::RESERVATION_PENDING);
            }])->with(["packagePayable" => function ($query) {
                return $query->where('status', '=', UserDoctorPackage::PACKAGE_PENDING);
            }])->with(["penalizePackagePayable" => function ($query) {
                return $query->where('status', '=', UserDoctorPackage::PACKAGE_PENDING);
            }])->find($id);
        } else {
            if ($request->filter == 'custom') {
                $start_date = $request->start_date ?? $this->project_date;
                $end_date = $request->end_date;
            }

            $data['payment'] = Doctor::with(["reservationPayable" => function ($query) use ($filter, $start_date, $end_date) {
                $query->where('reservation_status', '=', Reservation::RESERVATION_PENDING);
                $query = $this->filterResult($filter, $start_date, $end_date, $query);
                return $query;
            }])->with(["penalizeReservationPayable" =>function ($query) use ($filter, $start_date, $end_date) {
                $query->where('reservation_status', '=', Reservation::RESERVATION_PENDING);
                $query = $this->filterResult($filter, $start_date, $end_date, $query);
                return $query;
            }])->with(["packagePayable" => function ($query) use ($filter, $start_date, $end_date) {
                $query->where('status', '=', UserDoctorPackage::PACKAGE_PENDING);
                $query = $this->filterResult($filter, $start_date, $end_date, $query);
                return $query;
            }])->with(["penalizePackagePayable" => function ($query) use ($filter, $start_date, $end_date) {
                $query->where('status', '=', UserDoctorPackage::PACKAGE_PENDING);
                $query = $this->filterResult($filter, $start_date, $end_date, $query);
                return $query;
            }])->find($id);            
        }
        $data['filter'] = $filter;
        $data['doctor_id'] = $id;
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        return view('admin.payments.modals.payment_modal', $data);
    }

    public function pay_total_amount(Request $request, $id)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if ($start_date == null || $start_date == '') {
            $start_date = $this->project_date;
        }
        if ($end_date == null || $end_date == '') {
            $end_date = Carbon::now()->format('Y-m-d');
        }

        try {
            DB::beginTransaction();

            $transaction = Transaction::create([
                'receiver_type' => Doctor::class,
                'receiver_id' => $id,
                'billable_type' => 'withdraw',
                'sender_type' => Admin::class,
                'sender_id' => auth()->id(),
                'amount' => (float)$request->amount,
                'commission' => (float)$request->commission,
                'total' => (float)$request->total_without_commission,
                'gateway' => Transaction::BANK_TRANSACTION,
                'currency' => env('CASHIER_CURRENCY'),
                'description' => "Reservation and Packages Payment from {$start_date} to {$end_date}",
                'previous_amount' => 0,
            ]);
            $withdraw = WithdrawRequest::create([
                'doctor_id' => $id,
                'amount' => (float)$request->amount,
                'status' => WithdrawRequest::ACCEPTED,
                'transaction_id' => $transaction->id,
                'bank_transaction_id' => $request->bank_transaction_id,
                'notes' => "Reservation and Packages Payment - from {$start_date} to {$end_date}",
            ]);

            Reservation::where('doctor_id', $id)->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)->where('isPaid', 0)
                ->where('reservation_status', Reservation::RESERVATION_PENDING)
                ->update([
                    'isPaid' => 1,
                    'reservation_status' => Reservation::RESERVATION_PAID,
                    'withdraw_id' => $withdraw->id
                ]);

            UserDoctorPackage::where('doctor_id', $id)->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)->where('isPaid', 0)
                ->where('status', UserDoctorPackage::PACKAGE_PENDING)
                ->update([
                    'isPaid' => true,
                    'status' => UserDoctorPackage::PACKAGE_PAID,
                    'withdraw_id' => $withdraw->id,
                ]);

            DB::commit();
            return response()->json(['message' => 'Transaction completed.']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Transaction filed! ||' . $e->getMessage()]);
        }
    }
}
