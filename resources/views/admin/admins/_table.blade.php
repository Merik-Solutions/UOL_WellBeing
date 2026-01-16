<table id="datatable-buttons" class="table table-striped table-bordered  ">
    <thead>
    <tr>
        <th>{!! __("#") !!}</th>
        <th>{!! __("Name") !!}</th>
        <th>{!! __("Email") !!}</th>
        <th>{!! __("Phone") !!}</th>
       <th>{!! __("Date") !!}</th>
        <th>{!! __('Actions') !!}</th>

    </tr>
    </thead>
    @foreach($admins as $admin)
        <tr>

            <td>{!! $loop->iteration !!}</td>
            <td>{!! $admin->name !!}</td>
            <td>{!! $admin->email !!}</td>
            <td>{!! $admin->phone !!}</td>
            <td>{!! $admin->created_at !!}</td>
            <td>
         

            @component('admin.partials._edit_button',
                            [
                                'id'=>$admin->id,
                                'routeName'=>'admins',
                                'permission'=>"edit-admins"
                            ])
            @endcomponent

            @component('admin.partials._delete_button',
                            [
                                'id'=>$admin->id,
                                'routeName'=>'admins',
                                'permission'=>"delete-admins"
                            ])

            @endcomponent
            </td>
        </tr>
    @endforeach
    <tbody>

    </tbody>
</table>
