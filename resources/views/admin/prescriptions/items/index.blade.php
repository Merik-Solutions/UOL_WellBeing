@extends('admin.layouts.app')
@section('title'){!! __("blocks") !!} @endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="mt-0 header-title d-inline">@yield('title')</h4>
                @can('Create Prescriptionitem')

                <div class="mt-0 header-title float-right  d-inline">

                    <a class="btn btn-info text-white" href="{!! route('admin.blocks.create') !!}">
                        <i class="fas fa-plus"></i> {!! __("New")!!}</a>
                </div>
                @endcan
                <div class="pt-4">

                    @include('admin.blocks._table')

                </div>

            </div>
        </div>
    </div>


@endsection
