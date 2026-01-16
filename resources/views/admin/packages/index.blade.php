@extends('admin.layouts.app')
@section('title'){!! __("Packages") !!} @endsection

@section('content')

    <div class="row">
                <div class="card-box w-100">
                <h4 class="mt-0 header-title d-inline">@yield('title')</h4>
                @if(hasPermission('create-packages'))

                <div class="mt-0 header-title float-right  d-inline">

                    <a class="btn btn-info text-white" href="{!! route('admin.packages.create') !!}">
                        <i class="fas fa-plus"></i> {!! __("New")!!}</a>
                </div>
                @endif
                <div class="pt-4">

                    @include('admin.packages._table')

                </div>

            </div>
        </div>
    </div>


@endsection
