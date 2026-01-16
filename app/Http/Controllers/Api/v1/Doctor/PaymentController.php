<?php

namespace App\Http\Controllers\Api\v1\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Resources\Payment\PaidPaymentResource;
use App\Http\Resources\Payment\PaymentResource;
use App\Models\Doctor;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function doctorPayable(Request $request){
        $payments = Doctor::with('reservation','userDoctorPackage')->where('id', $request->doctor_id)->first();
        
        return responseJson(
            [
                'payments' => new PaymentResource($payments),
            ],
            __('loaded successfully'),
        );
    }

    public function payments(Request $request){
       
        $paid_payments =  Doctor::with(["paidReservations.withDraw","paidReservations" => function ($query) {
            return $query->where('isPaid', 1)
                ->where('reservation_status', '=', Reservation::RESERVATION_PAID);
        }])->with(["paidPackages.withDraw","paidPackages" => function ($query) {
            return $query->where('isPaid', 1);
        }])->find($request->doctor_id);
        
        return responseJson(
            [
                'paidPayments' => new PaidPaymentResource($paid_payments),
            ],
            __('loaded successfully'),
        );
        
        // return responseJson($paid_payments, 'Loaded Successfully');
    }
}
