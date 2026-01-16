<table id="datatable-buttons" class="table table-striped table-bordered  ">
    <thead>
    <tr>
        <th>{!! __("Name In Arabic") !!}</th>
        <th>{!! __("Name In English") !!}</th>
     {{--   <th>{!! __("Status") !!}</th>
--}}
        <th>{!! __('Actions') !!}</th>

    </tr>
    </thead>
    @foreach($roles as $role)
        <tr>
            <td>{!! $role->label_ar !!}</td>
            <td>{!! $role->label_en !!}</td>
            <td>
                @component('admin.partials._action_buttons',[
                'routeName'=>'roles'
                ,'id'=>$role->id,
                'permission'=>'Role'])
                @endcomponent
            </td>
        </tr>
    @endforeach
    <tbody>

    </tbody>
</table>
