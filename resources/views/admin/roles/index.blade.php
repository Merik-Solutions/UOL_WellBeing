{{-- @role('Admin') --}}
@extends('admin.layouts.app')
@section('title') {!! __("Roles") !!} @endsection

@section('content')

    <div class="bg-light p-4 rounded">
        <h1>{!! __("Roles") !!}</h1>
        @if(hasPermission('create-roles'))
        <div class="lead">
            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary btn-sm float-right">
                <i class="fas fa-plus"></i> {!! __("New")!!}</a>
        </div>
        @endif
        {{-- <div class="mt-2">
            @include('layouts.partials.messages')
        </div> --}}

        <table class="table table-bordered">
          <tr>
             <th width="1%">No</th>
             <th>Name</th>
             <th width="3%" colspan="3">Action</th>
          </tr>
          @php $i =1; @endphp
            @foreach ($roles as $key => $role)
            <tr>
                <td>{{ $i++ }}</td>
                {{-- <td>{{ $role->id }}</td> --}}
                <td>{{ Str::upper($role->name) }}</td>
                <td>
                    <a class="btn btn-info btn-sm" href="{{ route('admin.roles.show', $role->id) }}">Show</a>
                </td>
                <td>
                    @if ($role->id == 1)
                    No Edit
                    @else
                        @if(hasPermission('edit-roles'))
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.roles.edit', $role->id) }}">Edit</a>
                        @endif
                    @endif
                </td>
                <td>
                    @if ($role->id == 1)
                    No Delete
                    @else
                            @if(hasPermission('delete-roles'))

                                {!! Form::open(['method' => 'DELETE','route' => ['admin.roles.destroy', $role->id],'style'=>'display:inline']) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                {!! Form::close() !!}
                            @endif
                    @endif
                </td>
            </tr>
            @endforeach
        </table>

        <div class="d-flex">
            {!! $roles->links() !!}
        </div>

    </div>
@endsection
{{-- @endrole --}}
