@extends('admin.layouts.app')
@section('title')
{!! __('Refund Requests') !!}
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card-box">
            <h4 class="mt-0 header-title d-inline">@yield('title')</h4>

            <div class="pt-4">
                <table id="datatable-buttons" class="table table-striped table-bordered  ">
                    <thead>
                        <tr>
                            <th>{!! __('#') !!}</th>
                            <th>{!! __('Name ') !!}</th>
                            <th>{!! __('amount') !!}</th>
                            <th>{!! __('Transaction No.') !!}</th>
                            <th>{!! __('Status') !!}</th>
                            <th>{!! __('Date') !!}</th>
                            <th>{!! __('Actions') !!}</th>

                        </tr>
                    </thead>
                    @foreach ($refund_requests as $index => $refund_request)                                                            
                    @if($reservations[$index]->status != 'canceled')
                    <tr>
                        <td>{!! $loop->iteration !!}</td>
                        <td>{!! $patients[$index]->name !!}</td>
                        <td>{!! $refund_request->transaction->amount !!}</td>
                        <td>{!! $refund_request->transaction_id !!}</td>
                        <td>{!! $refund_request->status !!}</td>
                        <td>{!! $refund_request->created_at !!}</td>
                        <td>

                        @if(hasPermission('accept-refunds'))
                            <a class="btn btn-warning text-white" href="{{url('admin/en/reservation_cancel/'.$reservations[$index]->patient_id.'/'.$reservations[$index]->id)}}">Accept
                                <i class=" fas fa-check"></i>
                            </a>
                         @endif                 
                        </td>
                        
                    </tr>                    
                    @endif 
                    @endforeach
                    <tbody>

                    </tbody>
                </table>


            </div>

        </div>
    </div>
</div>
@endsection
