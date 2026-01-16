<table id="datatable-buttons" class="table table-striped table-bordered  ">
    <thead>
    <tr>
        <th>{!! __("Action") !!}</th>
        <th>{!! __("Old") !!}</th>
        <th>{!! __("New") !!}</th>
        <th>{!! __("By") !!}</th>

    </tr>
    </thead>
    @foreach($logs as $log)

        <tr>
            <td>{!! $log->description !!}</td>
            <td>{!! $log->email !!}</td>
            <td>{!! $log->subject !!}</td>
            <td>{!! $log->message !!}</td>
            <td>{!! $log->reply !!}</td>
            <td>{!! optional($log->seen_at)->format('Y-m-d H:i A') !!}</td>
            <td>{!! optional($log->admin)->name !!}</td>
            <td>
                @component('admin.partials._action_buttons',
                [
                'id'=>$log->id,
                'routeName'=>'logs',
                'permission'=>'log'
                ])
                @endcomponent
            </td>

        </tr>
    @endforeach
    <tbody>

    </tbody>
</table>
