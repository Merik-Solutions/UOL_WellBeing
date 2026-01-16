<table id="transactions_table" class="table table-striped table-bordered">
    {{-- <table id="datatable-buttons" class="table table-striped table-bordered"> --}}
        <thead>
            <tr>
                <th>Id#</th>
                <th>Sender</th>
                <th>Receiver</th>
                <th>Pay For</th>
                <th>Receiver amount</th>
                <th>App Commission</th>
                <th>Service Charges</th>
                <th>VAT</th>
                <th>Total</th>
                <th>gateway</th>
                <th>Invoice Id</th>
                <th>Description</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach ($transactions as $transaction)
                <tr>
                    <td>{!! $transaction->id !!}</td>
    
                    <td>
                        @if (isset($transaction->sender->name))
                            {!! @$transaction->sender->name !!}
                        @else
                            No Name {!! @$transaction->sender->phone !!}
                        @endif
                    </td>
                    <td>{!! @$transaction->receiver->name !!}</td>
                    <td>{!! __($transaction->billable_type) !!}</td>
                    <td>{!! number_format( $transaction->amount,2) !!}</td>
                    <td>{!! number_format( $transaction->commission,2) !!}</td>
                    <td>{!! number_format($transaction->commission+$transaction->amount,2) !!}</td>
                    <td>{!! number_format($transaction->vat_tax??0.00,2) !!}</td>
                    <td>{!! number_format($transaction->total,2) !!}</td>
                    <td>{!! __($transaction->gateway) !!}</td>
                    <td>{!! $transaction->invoice_id !!}</td>
                    <td>{!! $transaction->description !!}</td>
                    <td>{!! $transaction->created_at !!}</td>
    
                </tr>
            @endforeach --}}
    
        </tbody>
    </table>