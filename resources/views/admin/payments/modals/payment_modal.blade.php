@php

$packageTotal = $payment?->packagePayable?->udp_total ?? 0.0;
$reservationTotal = $payment?->reservationPayable?->reservation_total ?? 0.0;
$ressPenaltize = $payment?->penalizeReservationPayable?->reservation_total ?? 0.0;
$packagesPenaltize = $payment?->penalizePackagePayable?->udp_total ?? 0;
$totalPayable = $packageTotal + $reservationTotal;

$pay = appCommission($reservationTotal,$packageTotal);

if($filter == 'weekly'){        
    $start_date = \Carbon\Carbon::now()->startOfWeek();
    $end_date = \Carbon\Carbon::now()->endOfWeek();
}elseif ($filter == 'monthly') {
    $start_date = \Carbon\Carbon::now()->startOfMonth();
    $end_date = \Carbon\Carbon::now()->endOfMonth();
}elseif($filter == 'All'){
    $start_date = '';
    $end_date = '';
}
@endphp


<div class="modal fade bd-example-modal-lg" id="payment_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
<div class="modal-content">
  <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLongTitle">Pay to Dr. {{ !empty($payment->name_en) ? $payment->name_en : (!empty($payment->name_ar) ? $payment->name_ar : 'kinda' )}}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">       
    <div class="row">
        <div class="col-12">
            <h5>Doctor bank details</h5>
            @php 
                $bank = null;
                if(isset($payment->banks) && !empty($payment->banks->data)){
                    $bank = $payment->banks->data;
                }
            @endphp
            <table class="table table-striped table-bordered">
                <thead>
                    <th>Account Title </th>
                    <th>Bank </th>
                    <th>Account Number </th>
                    <th>IBAN </th>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$bank['account_holder_name'] ?? 'n/a'}}</td>
                        <td>{{$bank['bank_name'] ?? 'n/a'}}</td>
                        <td>{{$bank['account_number'] ?? 'n/a'}}</td>
                        <td>{{$bank['account_iban'] ??  'n/a'}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-12">
            <h5>Payment details</h5>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <td><b>Reservation Total </b></td>
                        <td><b>Packages Total </b></td>
                        <td><b>Commission Total </b></td>
                        <td><b>Payable Total </b></td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td id="reservation_total">{{number_format($reservationTotal + $ressPenaltize,2)}}</td>
                        <td id="package_total">{{number_format($packageTotal + $packagesPenaltize,2)}}</td>
                        <td id="commission">{{ number_format($pay['commission'],2) }}</td>
                        <td>{{ number_format($pay['payable'] + $ressPenaltize + $packagesPenaltize,2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
       
    </div>

    <form>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="formDate" class="col-form-label">From Date:</label>
                    <input value = "{{$start_date}}" type="date" class="form-control" name="fromDate" id="fromDate">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="toDate" class="col-form-label">To Date:</label>
                    <input value="{{$end_date}}" type="date" class="form-control" name="toDate" id="toDate" data-filter="modal" data-id={{$doctor_id}}>
                  </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label title="Enter bank transaction id." for="transaction_id" class="col-form-label">Bank Transaction ID</label>
                    <input title="Enter bank transaction id." type="text" class="form-control" name="transaction_id" id="transaction_id" value="" required>
                  </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="total_payable" class="col-form-label">Total Pay</label>
                    <input type="text"  class="form-control" 
                        name="total_payable" id="total_payable"
                        style="background: #eeeff2;"
                        value="{{ number_format($pay['payable'],2) }}" required readonly>
                  </div>
            </div>
        </div>
        
        
        
      </form>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    @if($totalPayable > 0)
        <button data-doctor = "{{$doctor_id}}" type="button" class="btn btn-success pay_total_amount">Pay Now</button>
    @endif
  </div>
</div>
</div>
</div>


<input type="hidden" value="{{$totalPayable}}" id="total_without_commission">