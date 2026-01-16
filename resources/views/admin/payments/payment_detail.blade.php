@extends('admin.layouts.app')
@section('title')
    {!! __(ucfirst($payments?->reservation[0]?->doctor?->name ?? ' ')." Payment Details") !!}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="d-flex justify-content-between">
                    <h4 class="mt-0 header-title d-inline">
                        {{ucfirst($payments?->reservation[0]?->doctor?->name ?? ' ')." ".ucfirst($payments?->reservation[0]?->reservation_status ?? '')." Payment Details"}}
                    </h4>
                    <div>
                        <a class="btn border" href="{{ URL::previous() }}" style="color:#716e6e;">
                            <i class="fas fa-back-arrow"></i>
                            {!! __('Back') !!}
                        </a>
                    </div>
                </div>
                <div class="pt-4">
                    <nav>
                        <div class="nav nav-tabs" id="payment-tab" role="tablist">

                            <a class="nav-item nav-link active" id="reservations-tab" data-toggle="tab" href="#reservations"
                                role="tab" aria-controls="reservations" aria-selected="true">{!! __('Reservations') !!}
                            </a>

                            {{-- @if($status !== 'disputed') --}}
                            <a class="nav-item nav-link " id="packages-tab" data-toggle="tab" href="#packages"
                                role="tab" aria-controls="packages" aria-selected="true">{!! __('Message Packages') !!}
                            </a>
                            {{-- @endif --}}

                        </div>
                    </nav>
                    <div class="tab-content" id="payment-tabContent">


                        <div class="tab-pane fade show active" id="reservations" role="tabpanel"
                            aria-labelledby="open--tab">

                            <table class="table table-striped table-bordered dataTable_payment">
                                <thead>
                                    <th>res ID</th>
                                    <th>Patient Name</th>
                                    <th>Price</th>
                                    <th>Commission</th>
                                    <th>Penalty</th>
                                    <th>Date</th>
                                    {{-- <th>Status</th> --}}
                                    {{-- <th>Bank Transaction ID</th> --}}
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($payments->reservation as $res)
                                        @php
                                            $pay = appCommission($res->price);
                                        @endphp
                                        <tr>
                                            <td>{{ $res->id }}</td>
                                            <td>{{ $res->patient->name }}</td>
                                            <td>{{ number_format($res->price, 2) }}</td>
                                            <td>{{ $pay['commission'] }}</td>
                                            <td>{{ $res->penalty_percent ?? 00.00 }}</td>
                                            <td>{{ date('Y-m-d', strtotime($res->date)) }}</td>
                                            {{-- <td @if ($res->reservation_status == 'disputed') style="color: red;" @endif>
                                                {{ ucfirst($res->reservation_status) }}
                                            </td> --}}
                                            {{-- <td>{{ $res->withDraw?->bank_transaction_id ?? 'n/a' }}</td> --}}
                                            <td>
                                                <a class="btn btn-info text-white"
                                                    href="javascript:reservation_detail('{{ $res->id }}')">
                                                    {{-- <i class="fas fa-stethoscope"></i> --}}
                                                    {!! __('Details') !!}
                                                </a>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div id="reservation_detail_container"></div>

                        </div>

                        {{-- @if($status !== 'disputed' ) --}}
                            <div class="tab-pane fade show " id="packages" role="tabpanel" aria-labelledby="open--tab">
                                
                                <table class="table table-striped table-bordered dataTable_payment">
                                    <thead>
                                        <th>res ID</th>
                                        <th>Patient Name</th>
                                        <th>Package Title</th>
                                        <th>Price</th>
                                        <th>Commission</th>
                                        <th>Penalty</th>
                                        {{-- <th>Bank Transaction ID</th> --}}
                                        <th>Date</th>
                                        <th>Expire At</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($payments->userDoctorPackage as $udp)
                                            @php
                                                $pay = appCommission($udp->price);
                                            @endphp
                                            <tr>
                                                <td>{{ $udp->id }}</td>
                                                <td>{{ $udp->patient->name }}</td>
                                                <td>{{ $udp->package->name_en }}</td>
                                                <td>{{ number_format($udp->price, 2) }}</td>
                                                <td>{{ $pay['commission'] }}</td>
                                                <td>{{ $udp->penalty_percent ?? 00.00 }}</td>
                                                {{-- <td>{{ $udp->withDraw?->bank_transaction_id ?? 'n/a' }}</td> --}}
                                                <td>{{ date('Y-m-d', strtotime($udp->created_at)) }}</td>
                                                <td>{{ date('Y-m-d', strtotime($udp->expired_at)) }}</td>
                                                <td><span
                                                        class="{{ $udp->expired_at < Carbon\Carbon::now() ? 'text-danger' : 'text-success' }}">{{ $udp->expired_at < Carbon\Carbon::now() ? 'Expired' : 'Active' }}</span>
                                                </td>
                                                <td>
                                                    <a class="btn btn-info text-white"
                                                        href="javascript:package_detail('{{ $udp->id }}')">
                                                        {{-- <i class="fas fa-stethoscope"></i> --}}
                                                        {!! __('Details') !!}
                                                    </a>
                                                </td>

                                            </tr>
                                        @endforeach
                                    
                                    </tbody>
                                </table>

                            </div>
                            <div id="package_detail_container"></div>
                        {{-- @endif --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function reservation_detail(id) {
            let url = "{{ route('admin.show_reservation_detail', ':id') }}";
            url = url.replace(':id', id),
            $.ajax(url, {
                method: 'post',
                processData: false,
                contentType: false,
                cache: false,
                success: function(response) {
                    $('#reservation_detail_container').html(response);
                    $('#reservation_detail_modal').modal('show');

                },
                error: function(error) {}
            });
        }
        function package_detail(id) {
            let url = "{{ route('admin.show_package_detail', ':id') }}";
            url = url.replace(':id', id),
            $.ajax(url, {
                method: 'post',
                processData: false,
                contentType: false,
                cache: false,
                success: function(response) {
                    $('#package_detail_container').html(response);
                    $('#package_detail_modal').modal('show');

                },
                error: function(error) {}
            });
        }
    </script>
@endpush
