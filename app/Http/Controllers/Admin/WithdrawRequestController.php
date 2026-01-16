<?php

namespace App\Http\Controllers\Admin;

use App\Models\Patient;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\RefundRequest;

use App\Models\WithdrawRequest;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Repositories\interfaces\WithdrawRequestRepository;
use App\Notifications\WithdrawAccepted;
use App\Notifications\WithdrawRejected;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class WithdrawRequestController extends Controller
{
    protected $repo;

    public function __construct(WithdrawRequestRepository $repo)
    {
        $this->middleware('permission:show-withdrawRequests')->only('index');
        $this->middleware('permission:update-withdrawRequests')->only('update');
        $this->middleware('permission:show-refunds')->only('refund_index');
        $this->repo = $repo;
    }

    /**
     * index
     *
     * @return  \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        // Permission::create(['name' => 'update-withdrawRequests']);
        // dd(auth()->user());

    
        return view('admin.transactions.withdraw_requests', [
            'withdraw_requests' => $this->repo
                ->with('doctor', 'transaction')
                ->orderBy('updated_at', 'desc')
                ->get(),
        ]);
    }
    public function update(Request $request, WithdrawRequest $withdrawRequest)
    {
        $inputs = $request->validate([
            'status' => [
                'required',
                Rule::in([WithdrawRequest::ACCEPTED, WithdrawRequest::REFUSED]),
            ],
            'notes' => ['required_if:status,' . WithdrawRequest::REFUSED],
            'bank_transaction_id' =>['required']
        ]);

        $this->handleStatus($inputs, $withdrawRequest);
        toast(__('Updated Successfully'), 'sucess');
        return back();
    }
    /**
     *
     * @param   array   $inputs Description
     * @param    WithdrawRequest  $withdrawRequest Description
     *
     * @return  type
     *
     */
    private function handleStatus(
        array $inputs,
        WithdrawRequest $withdrawRequest,
    ): WithdrawRequest {
        switch ($inputs['status']) {
            case WithdrawRequest::ACCEPTED:
                $withdrawRequest->accept($inputs['bank_transaction_id']);
                break;

            case WithdrawRequest::REFUSED:
                $withdrawRequest->refused($inputs['notes']);
                break;
        }

        if($withdrawRequest->status==='accepted'){
            $withdrawRequest->doctor->notify(new WithdrawAccepted($withdrawRequest));

        }else if($withdrawRequest->status==='refused'){
            $withdrawRequest->doctor->notify(new WithdrawRejected($withdrawRequest));
        }

        return $withdrawRequest;
    }


    public function refund_index()
    {
        // if(!permissionCheck(\Illuminate\Support\Facades\Route::current()->action['as'])){
        //     abort(403);
        // }
        $query['refund_requests'] = RefundRequest::whereHas('transaction', function($q){$q->where('billable_type', '=', 'reservation');
        })->with('refundable')->with('transaction')->get();

        $reservations=array();
        $patients=array();

        foreach ( $query['refund_requests'] as $key => $refund_request) {            
            array_push($reservations, Reservation::where('id',$refund_request->transaction['billable_id'])->first());            
        }
        $query['reservations'] = $reservations;

        foreach ($reservations as $key => $reservation) {
            array_push($patients,Patient::where('id',$reservation->patient_id)->first());            
        }

        $query['patients'] = $patients;
        
        return view('admin.transactions.refund_requests',$query);
    }
}
