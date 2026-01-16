<div class="">
    <nav>
        <div class="nav nav-tabs" id="payment-tab" role="tablist">

            {{-- <a class="nav-item nav-link active" id="all_pay-tab" data-toggle="tab"
                                    href="#all_pay"
                                    role="tab" aria-controls="all_pay"
                                    aria-selected="false">{!! __("All Payments") !!}
                                    </a> --}}

            <a class="nav-item nav-link active" id="pending_pay-tab" data-toggle="tab" href="#pending_pay" role="tab" aria-controls="pending_pay" aria-selected="true">{!! __("Pending") !!}
            </a>

            <a class="nav-item nav-link " id="disputed_pay-tab" data-toggle="tab" href="#disputed_pay" role="tab" aria-controls="disputed_pay" aria-selected="true">{!! __("Disputed") !!}
            </a>

            <a class="nav-item nav-link" id="paid_pay-tab" data-toggle="tab" href="#paid_pay" role="tab" aria-controls="paid_pay" aria-selected="false">{!! __("Paid") !!}
            </a>

        </div>
    </nav>
    <div class="tab-content" id="payment-tabContent">

        {{--<div class="tab-pane fade show active" id="all_pay" role="tabpanel"
                                    aria-labelledby="open--tab">

                                    <table class="table table-striped table-bordered dataTable_payment">
                                        <thead>
                                            <tr>
                                                <td>Doctor</td>
                                                <td>Reservations Total</td>
                                                <td>Packages Total</td>
                                                <td>Total Payable</td>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($paymentsAll as $payment)
                                                @php 
                                                        $packageTotal =  isset($payment->packagePayable->udp_total) ? $payment->packagePayable->udp_total : 0.00;                                        
                                                        $reservationTotal = isset($payment->reservationPayable->reservation_total) ? $payment->reservationPayable->reservation_total : 0.00; 
                                                        $totalPayable = $packageTotal +$reservationTotal;
                                                @endphp
                                                    <tr>
                                                        <td>{{ !empty($payment->name_en) ? $payment->name_en : (!empty($payment->name_ar) ? $payment->name_ar : 'kinda' )}}</td>
        <td>{{ number_format($reservationTotal,2) ?? 0.00}}</td>
        <td>{{number_format($packageTotal,2) ?? 0.00}}</td>
        <td>{{ number_format($totalPayable,2) ?? 0.00}}</td>
        </tr>
        @endforeach
        </tbody>
        </table>
    </div> --}}


    <div class="tab-pane fade show active" id="pending_pay" role="tabpanel" aria-labelledby="open--tab"> 

        <table class="table table-striped table-bordered dataTable_payment">
            <thead>
                <tr>
                    <td>Doctor</td>
                    <td>Reservations Total</td>
                    <td>Packages Total</td>
                    <td>Total Payable</td>
                    <td>Status</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
                @foreach($pending as $payment)
                @php
                $packageTotal = $payment?->packagePayable?->udp_total ?? 0.00;
                $reservationTotal = $payment?->reservationPayable?->reservation_total ?? 0.00;
                $totalPayable = $packageTotal + $reservationTotal;
                @endphp
                @if($totalPayable > 0)

                <tr>
                    <td>{{ $payment?->name_en ?? $payment?->name_ar ?? 'kinda' }}</td>
                    <td>{{ number_format($reservationTotal,2) ?? 0.00}}</td>
                    <td>{{number_format($packageTotal,2) ?? 0.00}}</td>
                    <td>{{ number_format($totalPayable,2) ?? 0.00}}</td>
                    <td>{{ 'pending' }}</td>
                    <td>
                        <a class="btn btn-info text-white" href="javascript:doctor_payment_details('{{$payment->id}}','pending')"> 
                            {!! __("Details") !!}
                        </a>
                        <a data-id="{{$payment->id}}" class="btn btn-success text-white pay_money"> 
                            {!! __("Pay") !!}
                        </a>
                    </td>
                </tr>
                @endif

                @endforeach
            </tbody>
        </table>
        <div id="payment_modal_container"></div>


    </div>

    <div class="tab-pane fade show " id="disputed_pay" role="tabpanel" aria-labelledby="open--tab"> 

        <table class="table table-striped table-bordered dataTable_payment">
            <thead>
                <tr>
                    <td>Doctor</td>
                    <td>Reservations Total</td>
                    <td>Packages Total</td>
                    <td>Total Payable</td>
                    <td>Status</td>
                    <td>Action</td>

                </tr>
            </thead>
            <tbody>
                @foreach($disputed as $payment)
                @php
                $reservationTotal = $payment?->reservationPayable?->reservation_total ?? 0.00;
                $packageTotal = $payment?->packagePayable?->udp_total ?? 0.00;
                $totalPayable = $reservationTotal + $packageTotal;
                @endphp
                @if($reservationTotal > 0)
                <tr>
                    <td>{{ $payment?->name_en ?? $payment?->name_ar ?? 'kinda' }}</td>
                    <td>{{ number_format($reservationTotal,2) ?? 0.00}}</td>
                    <td>{{ number_format($packageTotal,2) ?? 0.00}}</td>
                    <td>{{ number_format($totalPayable,2) ?? 0.00}}</td>
                    <td>{{ 'disputed' }}</td>
                    <td>
                        <a class="btn btn-info text-white" href="javascript:doctor_payment_details('{{$payment->id}}','disputed')"> 
                            {!! __("Details") !!}
                        </a>
                       
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>

    </div>

    <div class="tab-pane fade  " id="paid_pay" role="tabpanel" aria-labelledby="open--tab">

        <table class="table table-striped table-bordered dataTable_payment">
            <thead>
                <tr>
                    <td>Doctor</td>
                    <td>Reservations Total</td>
                    <td>Packages Total</td>
                    <td>Total Payable</td>
                    <td>Status</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
                @foreach($confirmed as $payment)
                @php
                    $packageTotal = $payment?->packagePayable?->udp_total ?? 0.00;
                    $reservationTotal = $payment?->reservationPayable?->reservation_total ?? 0.00;
                    $totalPayable = $packageTotal + $reservationTotal;
                @endphp
                @if($totalPayable > 0)
                <tr>
                    <td>{{ $payment?->name_en ?? $payment?->name_ar ?? 'kinda'}}</td>
                    <td>{{ number_format($reservationTotal,2) ?? 0.00}}</td>
                    <td>{{number_format($packageTotal,2) ?? 0.00}}</td>
                    <td>{{ number_format($totalPayable,2) ?? 0.00}}</td>
                    <td>{{ 'paid' }}</td>
                    <td>
                        <a class="btn btn-info text-white" href="javascript:doctor_payment_details('{{$payment->id}}','confirmed')"> 
                            {!! __("Details") !!}
                        </a>
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>


    </div>


</div>

</div>