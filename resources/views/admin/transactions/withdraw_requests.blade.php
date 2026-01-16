@extends('admin.layouts.app')
@section('title') {!! __("Withdraw Requests") !!} @endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="mt-0 header-title d-inline">@yield('title')</h4>

                <div class="pt-4">


                    <table id="datatable-buttons" class="table table-striped table-bordered table-responsive ">
                        <thead>
                        <tr>
                            <th>{!! __("#") !!}</th>
                            <th>{!! __("Image") !!}</th>
                            <th>{!! __("Name ") !!}</th>
                            <th>{!! __("amount") !!}</th>
                            <th>{!! __("status") !!}</th>
                            <th>{!! __("Transaction No.") !!}</th>
                            <th>{!! __("Bank Transaction Id.") !!}</th>
                            <th>{!! __("Bank Title") !!}</th>
                            <th>{!! __("Bank Name") !!}</th>
                            <th>{!! __("IBAN") !!}</th>
                            <th>{!! __("Notes") !!}</th>
                            <th>{!! __("Date") !!}</th>
                            <th>{!! __('Actions') !!}</th>

                        </tr>
                        </thead>
                        @foreach($withdraw_requests as $withdraw_request)
                            <tr>
                                <td>{!! $loop->iteration !!}</td>
                                <td>

                            <a href="{{$withdraw_request->doctor->image}}" data-fancybox >
                                <img src="{{$withdraw_request->doctor->image}}" width="100" height="100" alt="{{$withdraw_request->doctor->name}}"
                                onerror="this.src='{!! asset('dashboard/logo.png') !!}'"/>
                            </a>
                                </td>
                                <td>{!! $withdraw_request->doctor->name !!}</td>
                                <td>{!! $withdraw_request->amount !!}</td>
                                <td>{!! __($withdraw_request->status) !!}</td>
                                <td>{!! $withdraw_request->transaction_id !!}</td>
                                <td>{!! $withdraw_request->bank_transaction_id ?? 0 !!}</td>
                                @if($withdraw_request->doctor->banks == null)
                                    <td>{!! __("No Bank Title") !!}</td>
                                    <td>{!! __("No Bank Title") !!}</td>
                                    <td>{!! __("No Bank Title") !!}</td>
                                @else
                                    <td>{!! $withdraw_request->doctor->banks->title !!}</td>
                                    <td>{!! $withdraw_request->doctor->banks->bank_name !!}</td>
                                    <td>{!! $withdraw_request->doctor->banks->iban !!}</td>
                                @endif
                                <td>{!! $withdraw_request->notes !!}</td>
                                <td>{!! $withdraw_request->created_at !!}</td>
                                <td>
                                @if(hasPermission('update-withdrawRequests'))
                                    @if($withdraw_request->status==$withdraw_request::WAITING)                                    
                                        <a class="btn btn-warning text-white"
                                            onclick="
                                                Swal.fire({
                                                title: 'Please Enter Transaction Id',
                                                input: 'text',
                                                inputAttributes: {
                                                    autocapitalize: 'off'
                                                }
                                                }).then(function(result){
                                                // var input = `<input type='hidden' name='bank_transaction_id' value= '${result.value}' `;
                                                var input = document.createElement('input');
                                                input.type = 'text';
                                                input.name = 'bank_transaction_id'; // set the CSS class
                                                input.value = result.value; // set the CSS class

                                                let form =  document.getElementById('accept-{!! route('admin.withdraw-requests.update',$withdraw_request->id) !!}-{!! $withdraw_request->id !!}');
                                                form.appendChild(input);
                                                Swal.fire({
                                                title: '{!! __('Are you sure?') !!}',
                                                text: '{!! __('You Will Not be able to revert this!') !!}',
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#3085d6',
                                                cancelButtonColor: '#d33',
                                                confirmButtonText: '{!! __('Yes, Accept it!') !!}'
                                                }).then((result) => {


                                                if (result.value) {
                                            
                                                form.submit();
                                                }
                                                });event.preventDefault()}
                                                )">
                                                <i class=" fas fa-check"></i>
                                        </a>
                                        <form action="{!! route('admin.withdraw-requests.update',$withdraw_request->id) !!}" method="POST"
                                            style="display: none;"
                                            id="accept-{!! route('admin.withdraw-requests.update',$withdraw_request->id) !!}-{!! $withdraw_request->id !!}">
                                            @csrf()
                                            @method('patch')
                                            <input type="hidden" name="status" value="{{$withdraw_request::ACCEPTED}}"/>
                                        </form>

                                        <a class="btn btn-warning text-white"
                                            onclick="
                                                Swal.fire({
                                                title: '{!! __('Please , Enter Refuse Reason') !!}',
                                                text: '{!! __('You Will Not be able to revert this!') !!}',
                                                icon: 'warning',
                                                input: 'textarea',
                                                showCancelButton: true,
                                                confirmButtonColor: '#3085d6',
                                                cancelButtonColor: '#d33',
                                                confirmButtonText: '{!! __('Confrim') !!}',
                                                preConfirm: (note) =>{
                                                    document.getElementById('note-{{$withdraw_request->id}}').value=note;},
                                                }).then((result) => {
                                                if (result.isConfirmed) {

                                                    document.getElementById('refuse-{!! route('admin.withdraw-requests.update',$withdraw_request->id) !!}-{!! $withdraw_request->id !!}').submit();}
                                                });event.preventDefault()">
                                                <i class=" fas fa-times"></i>
                                        </a>
                                        <form action="{!! route('admin.withdraw-requests.update',$withdraw_request->id) !!}" method="POST"
                                            style="display: none;"
                                            id="refuse-{!! route('admin.withdraw-requests.update',$withdraw_request->id) !!}-{!! $withdraw_request->id !!}">
                                            @csrf()
                                            @method('patch')
                                            <input type="hidden" name="status" value="{{$withdraw_request::REFUSED}}"/>
                                            <input type="hidden" name="notes" id="note-{{$withdraw_request->id}}"/>
                                        </form>
                                    @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        <tbody>

                        </tbody>
                    </table>


                </div>

            </div>
        </div>
    </div>


@endsection
