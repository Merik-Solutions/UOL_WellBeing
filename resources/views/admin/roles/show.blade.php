@extends('admin.layouts.app')
@section('title') {!! __("Roles") !!} @endsection

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>{{ ucfirst($role->name) }} Role</h1>
        <div class="lead">

        </div>

        <div class="container mt-4">

            <h3>Assigned permissions</h3>

            <table class="table table-striped">
                <thead>
                    <th scope="col" width="20%">Name</th>
                    <th scope="col" width="1%">Guard</th>
                </thead>

                

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




            </table>
        </div>

    </div>
    <div class="mt-4">
        <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-info">Edit</a>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-default">Back</a>
    </div>
@endsection
