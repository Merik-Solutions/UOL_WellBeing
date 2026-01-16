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
        @foreach ($disputed as $payment)
            @php
                $reservationTotal = $payment->reservationPayable->reservation_total ?? 0.0;
                $packageTotal =  $payment->packagePayable->udp_total ?? 0.00; 
                $totalPayable = $packageTotal + $reservationTotal;
                // print_r($payment->packagePayable->udp_total ?? 0);
            @endphp
            @if ($totalPayable > 0 )
                <tr>
                    <td>{{ $payment?->name_en?: 'kinda' }}
                    </td>
                    <td>{{ number_format($reservationTotal, 2) ?? 0.0 }}</td>
                    <td>{{ number_format($packageTotal, 2) ?? 0.0 }}</td>
                    <td>{{ number_format($totalPayable, 2) ?? 0.0 }}</td>
                    <td>{{ 'disputed' }}</td>
                    <td>
                        <a class="btn btn-info text-white"
                            href="javascript:doctor_payment_details('{{ $payment->id }}','disputed')">
                            {{-- <i class="fas fa-info"></i> --}}
                            {!! __('Details') !!}
                        </a>
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>