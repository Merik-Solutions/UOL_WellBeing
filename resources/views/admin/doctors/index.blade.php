@extends('admin.layouts.app')
@section('title') {!! __("Doctors") !!} @endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="mt-0 header-title d-inline">@yield('title')</h4>

                @if(hasPermission('create-doctors'))
                <div class="mt-0 header-title float-right  d-inline">

                    <a class="btn btn-info text-white" href="{!! route('admin.doctors.create') !!}">
                        <i class="fas fa-plus"></i> {!! __("New")!!}</a>
                </div>
                @endif
                <div class="pt-4">


                    <nav>
                        <div class="nav nav-tabs" id="doctors-tab" role="tablist">
                            <a class="nav-item nav-link active" id="open-doctors-tab" data-toggle="tab"
                               href="#open-doctor" role="tab" aria-controls="open-doctor"
                               aria-selected="true">{!! __("Open Doctors") !!}</a>
                            <a class="nav-item nav-link" id="sub-cat-tab" data-toggle="tab" href="#blocked-doctor"
                               role="tab" aria-controls="blocked-doctor"
                               aria-selected="false">{!! __("Blocked Doctors") !!}</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="doctors-tabContent">
                        <div class="tab-pane fade show active" id="open-doctor" role="tabpanel"
                             aria-labelledby="open-doctors-tab">

                            @include('admin.doctors._table',['doctors'=>$active_doctors])

                        </div>
                        <div class="tab-pane fade" id="blocked-doctor" role="tabpanel" aria-labelledby="sub-cat-tab">

                            @include('admin.doctors._table',['doctors'=>$pending_doctors])

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>


@endsection
