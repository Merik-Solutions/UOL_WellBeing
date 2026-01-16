@extends('admin.layouts.app')
@section('title') {!! __("Reservations") !!} @endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="mt-0 header-title d-inline">@yield('title')</h4>
                @can('Create Prescription')

                <div class="mt-0 header-title float-right  d-inline">

                    <a class="btn btn-info text-white" href="{!! route('admin.reservations.create') !!}">
                        <i class="fas fa-plus"></i> {!! __("New")!!}</a>
                </div>
                @endcan
                <div class="pt-4">

                    <nav>
                        <div class="nav nav-tabs" id="reservations-tab" role="tablist">


                            <a class="nav-item nav-link active" id="active_reservations-tab" data-toggle="tab"
                               href="#active_reservations"
                               role="tab" aria-controls="active_reservations"
                               aria-selected="false">{!! __("Active Reservations") !!}
                            </a>


                            <a class="nav-item nav-link " id="accepted_reservations-tab" data-toggle="tab"
                               href="#accepted_reservations" role="tab" aria-controls="accepted_reservations"
                               aria-selected="true">{!! __("Accepted Reservation") !!}
                            </a>


                            <a class="nav-item nav-link " id="refused_reservations-tab" data-toggle="tab"
                               href="#refused_reservations" role="tab" aria-controls="accepted_reservations"
                               aria-selected="true">
                                {!! __("Refused Reservations") !!}
                            </a>

                            <a class="nav-item nav-link" id="canceled-reservations-tab" data-toggle="tab"
                               href="#canceled_reservations"
                               role="tab" aria-controls="canceled_reservations"
                               aria-selected="false">{!! __("Canceled Reservations") !!}
                            </a>

                            <a class="nav-item nav-link" id="finished_reservations-tab" data-toggle="tab"
                               href="#finished_reservations"
                               role="tab" aria-controls="finished_reservations"
                               aria-selected="false">{!! __("Finished Reservations") !!}
                            </a>

                        </div>
                    </nav>
                    <div class="tab-content" id="reservations-tabContent">

                        <div class="tab-pane fade show active" id="active_reservations" role="tabpanel"
                             aria-labelledby="open-patients-tab">
                            @include('admin.reservations._table',['reservations'=>$active_reservations])
                        </div>


                        <div class="tab-pane fade show " id="accepted_reservations" role="tabpanel"
                             aria-labelledby="open-patients-tab">
                            @include('admin.reservations._table',['reservations'=>$accepted_reservations])
                        </div>


                        <div class="tab-pane fade  " id="refused_reservations" role="tabpanel"
                             aria-labelledby="open-patients-tab">
                            @include('admin.reservations._table',['reservations'=>$refused_reservations])
                        </div>


                        <div class="tab-pane fade  " id="canceled_reservations" role="tabpanel"
                             aria-labelledby="open-patients-tab">
                            @include('admin.reservations._table',['reservations'=>$canceled_reservations])
                        </div>

                        <div class="tab-pane fade  " id="finished_reservations" role="tabpanel"
                             aria-labelledby="open-patients-tab">
                            @include('admin.reservations._table',['reservations'=>$finished_reservations])
                        </div>


                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection
