<table class="table table-striped table-bordered dataTable_payment">
    <thead>
        <tr>
            <td>Doctor</td>
            <td>Reservations Total</td>
            <td>Packages Total</td>
            <td>App Commission</td>
            <td>Total Payable</td>
            <td>Status</td>
            <td>Action</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($pending as $payment)
            @php
                $packageTotal = $payment?->packagePayable?->udp_total ?? 0.0;
                $reservationTotal = $payment?->reservationPayable?->reservation_total ?? 0.0;
                $ressPenaltize = $payment?->penalizeReservationPayable?->reservation_total ?? 0.0;
                $packagesPenaltize = $payment?->penalizePackagePayable?->udp_total ?? 0;
                $totalPayable = $packageTotal + $reservationTotal;
                $pay = appCommission($reservationTotal, $packageTotal);
            @endphp
            @if ($totalPayable > 0)
                <tr>
                    <td>{{ $payment?->name_en ?: 'kinda' }}
                    </td>
                    <td>{{ number_format($reservationTotal + $ressPenaltize, 2) ?? 0.0 }}</td>
                    <td>{{ number_format($packageTotal + $packagesPenaltize, 2) ?? 0.0 }}</td>
                    <td>{{ number_format($pay['commission'], 2) ?? 0.0 }}</td>
                    <td>{{ number_format($pay['payable']+ $ressPenaltize + $packagesPenaltize, 2) ?? 0.0 }}</td>
                    <td>{{ 'pending' }}</td>
                    <td>
                        <a class="btn btn-info text-white"
                            href="javascript:doctor_payment_details('{{ $payment->id }}','pending')">
                            {!! __('Details') !!}
                        </a>
                        <a data-id="{{ $payment->id }}" class="btn btn-success text-white pay_money">
                            {!! __('Pay') !!}
                        </a>
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
