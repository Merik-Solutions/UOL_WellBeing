@extends('admin.layouts.app')
@section('title') {!! __("Permissions") !!} @endsection
@section('content')

    <div class="bg-light p-4 rounded">
        <h4 class="mt-0 header-title d-inline">@yield('title')</h4>
        {{-- @can('Create Role')

        <div class="mt-0 header-title float-right  d-inline">

            <a class="btn btn-info text-white" href="{!! route('admin.permissions.create') !!}">
                <i class="fas fa-plus"></i> {!! __("New")!!}</a>
        </div>
        @endcan --}}

        {{-- <div class="mt-2">
            @include('layouts.partials.messages')
        </div> --}}

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Guard</th>
                <th scope="col" colspan="3" width="1%"></th>
            </tr>
            </thead>
            <tbody>
                @foreach($permissions as $parent=>$children)
                    <tr>
                        <td colspan="3">
                            <strong>{{strtoupper(str_replace('.', ' ', $parent))}}</strong>
                        </td>
                    </tr>

                    
                      @foreach($children as $child)
                        <tr> 
                            <td style="padding-left: 30px;">
                                {{ucfirst(explode('-',$child->name)[0])}}

                            </td>
                            <td>{{ $child->guard_name }}</td>
                            {{-- <td><a href="{{ route('admin.permissions.edit', $child->id) }}" class="btn btn-info btn-sm">Edit</a></td> --}}
                            {{-- <td>
                                {!! Form::open(['method' => 'DELETE','route' => ['admin.permissions.destroy', $child->id],'style'=>'display:inline']) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                {!! Form::close() !!}
                            </td> --}}
                            </tr>
                      @endforeach

                       
                   
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
