<table class="table table-striped table-bordered dataTable_payment">
    <thead>
        <tr>
            <td>Doctor</td>
            <td>Reservations Total</td>
            <td>Packages Total</td>
            <td>App Commission</td>
            <td>Total Payable</td>
            <td>Bank Transaction Id</td>
            <td>From - To Date</td>
            <td>Action</td>

        </tr>
    </thead>
    <tbody>
        @foreach ($confirmed as $payment)
            @php
                $all_payments = $payment->paidReservations->concat($payment->paidPackages)->groupBy('withdraw_id');
                
            @endphp
            @foreach ($all_payments as $key=>$paid_payment)
                @php
                    $packageTotal = 0;
                    $reservationTotal = 0;
                @endphp
                @foreach ($paid_payment as $paid)
                    @php
                        $reservationTotal = $paid->reservation_total + $reservationTotal;
                        $packageTotal = $paid->udp_total + $packageTotal;
                        $totalPayable = $packageTotal + $reservationTotal;
                        $pay = appCommission($reservationTotal, $packageTotal);
                        $note = $payment?->paidReservations[$loop->index]?->withDraw?->notes ?? false;
                        if($note){
                            $dates = explode('from',$note);
                        }
                    @endphp
                @endforeach

                @if ($totalPayable > 0)
                    <tr>
                        <td>{{ $payment?->name? : "Kinda" }}
                        </td>
                        <td>{{ number_format($reservationTotal, 2) ?? 0.0 }}</td>
                        <td>{{ number_format($packageTotal, 2) ?? 0.0 }}</td>
                        <td>{{ number_format($pay['commission'], 2) ?? 0.0 }}</td>
                        <td>{{ number_format($pay['payable'], 2) ?? 0.0 }}</td>
                        <td>
                            {{ 
                                $payment?->paidReservations[$loop->index]->withDraw->bank_transaction_id ??
                                $payment?->paidPackages[$loop->index]->withDraw->bank_transaction_id ??
                                'n/a'
                             }}
                        </td>
                        <td>{{ $dates[1] ?? 'n/a' }}</td>
                        <td>
                            <a class="btn btn-info text-white"
                                href="javascript:doctor_payment_details('{{ $payment->id }}','paid','{{$key}}')">
                                {!! __('Details') !!}
                            </a>
                        </td>
                    </tr>
                @endif
            @endforeach
        @endforeach
    </tbody>
</table>
