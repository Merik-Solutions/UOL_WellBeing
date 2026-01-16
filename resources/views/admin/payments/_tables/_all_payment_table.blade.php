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
        @foreach ($paymentsAll as $payment)
            @php 
                $packageTotal =  isset($payment->packagePayable->udp_total) ? $payment->packagePayable->udp_total : 0.00;                                        
                $reservationTotal = isset($payment->reservationPayable->reservation_total) ? $payment->reservationPayable->reservation_total : 0.00; 
                $totalPayable = $packageTotal +$reservationTotal;
            @endphp
            <tr>
                <td>{{ $payment?->name_en?: 'kinda' }}</td>
                <td>{{ number_format($reservationTotal,2) ?? 0.00}}</td>
                <td>{{number_format($packageTotal,2) ?? 0.00}}</td>
                <td>{{ number_format($totalPayable,2) ?? 0.00}}</td>
            </tr>
        @endforeach
    </tbody>
</table>