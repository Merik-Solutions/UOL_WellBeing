@extends('admin.layouts.app')
@section('title') {!! __("Edit role") !!} : {!! $role->name !!} @endsection

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>Update role</h1>
        <div class="lead">
            Edit role and manage permissions.
        </div>

        <div class="container mt-4">

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.roles.update', $role->id) }}">
                @method('patch')
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input value="{{ $role->name }}"
                        type="text"
                        class="form-control"
                        name="name"
                        placeholder="Name" required>
                </div>

                <label for="permissions" class="form-label">Assign Permissions</label>

                <table class="table table-striped">
                    <thead>
                        <th><input type="checkbox" name="all_permission"></th>
                        <th>Name</th>
                        <th>Guard</th>
                    </thead>

                    @foreach($permissions as $parent=>$children)

                            <tr>
                                <th class="pl-md-4" width="1%"><input type="checkbox" data-title="{{$parent}}" name="grouped_permission"></th>
                                <td style="margin-left: -50px;"><strong>{{strtoupper($parent)}}</strong></td>
                            </tr>
                            @foreach($children as $child)
                                <tr>
                                    <td class="pl-md-5">
                                        <input type="checkbox"
                                        name="permission[{{ $child->name }}]"
                                        value="{{ $child->name }}"
                                        class='permission {{$parent."_permission"}}'
                                        {{ in_array($child->name, $rolePermissions)
                                            ? 'checked'
                                            : '' }}>
                                    </td>
                                    <td>{{ucfirst(explode('-', $child->name)[0])}}</td>
                                    <td>{{ $child->guard_name }}</td>
                                </tr>
                            @endforeach

                    @endforeach
                </table>

                <button type="submit" class="btn btn-primary">Save changes</button>
                <a href="{{ route('admin.roles.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('[name="all_permission"]').on('click', function() {

                if($(this).is(':checked')) {
                    $.each($('.permission'), function() {
                        $(this).prop('checked',true);
                    });
                } else {
                    $.each($('.permission'), function() {
                        $(this).prop('checked',false);
                    });
                }

            });

            $('[name="grouped_permission"]').on('click', function() {

                let permission_parent = $(this).data('title');
                if($(this).is(':checked')) {
                    $.each($('.'+permission_parent+'_permission'), function() {
                        $(this).prop('checked',true);
                    });
                } else {
                    $.each($('.'+permission_parent+'_permission'), function() {
                        $(this).prop('checked',false);
                    });
                }

            });
        });
    </script>
@endpush
