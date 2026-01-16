<table id="datatable-buttons" class="table table-striped table-bordered  ">
    <thead>
    <tr>
        <th>{!! __("#") !!}</th>
        <th>{!! __("Date") !!}</th>
        <th>{!! __("Day") !!}</th>
        <th>{!! __("From") !!}</th>
        <th>{!! __("To") !!}</th>

    </tr>
    </thead>
    @foreach($schedules as $schedule)
        <tr>
            <td>{!! $loop->iteration !!}</td>
            <td>{!! $schedule->created_at !!}</td>
            <td>{!!days()[$schedule->day] ??null !!}</td>
            <td>
                @if($schedule->from_time!=null)
                {!! \Carbon\Carbon::parse($schedule->from_time)->format('h:i A') !!}<
                @endif
            </td>
            <td>
                @if($schedule->from_time!=null)

                {!! \Carbon\Carbon::parse($schedule->to_time)->format('h:i A')!!}</td>
 @endif
                {{-- <td>
                @component('admin.partials._action_buttons',
                ['id'=>$schedule->id,
                'routeName'=>'schedules',
                'permission'=>'Schedule'])
                @endcomponent

            </td> --}}
        </tr>
    @endforeach
    <tbody>

    </tbody>
</table>
