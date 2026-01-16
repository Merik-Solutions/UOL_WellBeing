@extends('admin.layouts.app')
@section('title'){!! __("schedules") !!} @endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="mt-0 header-title d-inline">@yield('title')</h4>
                @if(hasPermission('create-schedules'))

                <div class="mt-0 header-title float-right  d-inline">

                    <a class="btn btn-info text-white" href="{!! route('admin.schedules.create',request()->doctor) !!}">
                        <i class="fas fa-pencil-alt"></i> </a>
                </div>
                @endif
                <div class="pt-4">

                    @include('admin.schedules._table')

                </div>

            </div>
        </div>
    </div>


@endsection
