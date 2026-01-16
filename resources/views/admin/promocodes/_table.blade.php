<table id="datatable-buttons" class="table table-striped table-bordered  ">
    <thead>
    <tr>
        <th>{!! __("#") !!}</th>
        <th>{!! __("Date") !!}</th>
        <th>{!! __("Code") !!}</th>
        <th>{!! __("Type") !!}</th>
        <th>{!! __("Percent") !!}</th>
        <th>{!! __("Use Time") !!}</th>
        <th>{!! __("Expired At") !!}</th>
        <th>{!! __('Actions') !!}</th>

    </tr>
    </thead>
    @foreach($promocodes as $promocode)
        <tr>
            <td>{!! $loop->iteration !!}</td>
            <td>{!! $promocode->created_at !!}</td>
            <td>{!! $promocode->code !!}</td>
            <td>{!! __( $promocode->type) !!}</td>
            <td>{!!  $promocode->percent !!}</td>
            <td>{!!  $promocode->use_time??__("Always") !!}</td>
            <td>{!!  $promocode->expired_at??__("Always") !!}</td>
            <td>
                @component('admin.partials._edit_button',
                            [
                                'routeName'=>'promocodes',
                                'id'=>$promocode->id,
                                'permission'=>'edit-promoCodes'
                            ])
                @endcomponent

                @component('admin.partials._delete_button',
                                [
                                    'routeName'=>'promocodes',
                                    'id'=>$promocode->id,
                                    'permission'=>'delete-promoCodes'
                                ])

                @endcomponent



            </td>
        </tr>
    @endforeach
    <tbody>

    </tbody>
</table>
