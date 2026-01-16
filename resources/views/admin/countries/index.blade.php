@extends('admin.layouts.app')
@section('title') {!! __("Countries") !!} @endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="mt-0 header-title d-inline">@yield('title')</h4>
                @if(hasPermission('create-countries'))
                <div class="mt-0 header-title float-right  d-inline">

                    <a class="btn btn-info text-white" href="{!! route('admin.countries.create') !!}">
                        <i class="fas fa-plus"></i> {!! __("New")!!}</a>
                </div>
                @endif
                <div class="pt-4">

                            @include('admin.countries._table',['countries'=>$countries,'type'=>'main'])
                </div>
            </div>
        </div>
    </div>


@endsection
