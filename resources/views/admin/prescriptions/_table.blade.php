<table id="datatable-buttons" class="table table-striped table-bordered  ">
    <thead>
    <tr>
        <th>{!! __("Doctor") !!}</th>
        <th>{!! __("Patient") !!}</th>
        <th>{!! __("Day") !!}</th>
        <th>{!! __("From") !!}</th>
        <th>{!! __("To") !!}</th>
        <th>{!! __("Date") !!}</th>
        <th>{!! __('Actions') !!}</th>

    </tr>
    </thead>
    @foreach($reservations as $reservation)
        <tr>
            <td>{!! optional($reservation->doctor)->name !!}</td>
            <td>{!! optional($reservation->patient)->name !!}</td>
            <td>{!! $reservation->date!!}</td>
            <td>{!! Carbon\Carbon::parse($reservation->from_time)->format('H:i A') !!}</td>
            <td>{!! Carbon\Carbon::parse($reservation->to_time)->format('H:i A')!!}</td>
            <td>{!! $reservation->description !!}</td>
            <td>{!! $reservation->created_at !!}</td>
            <td>
                @component('admin.partials._action_buttons',
                ['routeName'=>'reservations',
                'id'=>$reservation->id,
                'permission'=>'Reservation'])
                @endcomponent
            </td>
        </tr>
    @endforeach
    <tbody>

    </tbody>
</table>
