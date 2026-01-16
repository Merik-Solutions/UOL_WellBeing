<table class="table table-striped table-bordered datatable-buttons ">
    <thead>
    <tr>
        <!--<th>{!! __("#") !!}</th>-->
        <th>{!! __("Patient") !!}</th>
        <th>{!! __("Doctor") !!}</th>
        <th>{!! __("res ID") !!}</th>
        <th>{!! __("Type") !!}</th>
        <th>{!! __("Lodged On") !!}</th>
        <th>{!! __("Status") !!}</th>
        <th>{!! __('Actions') !!}</th>

    </tr>
    </thead>
    @foreach($pending as $val)
        <tr>
            <!--<td>{!! $loop->iteration !!}</td>-->
            <td>{!! $val?->patient?->name? : 'n/a' !!}</td>
            <td>{!! $val?->doctor?->name_en? :'n/a' !!}</td>
            <td>{!! $val?->reservation_id? : '' !!}</td>
            <td>
                <span 
                @if(strtolower($val->type) == 'complaint') 
                    class="font-12 text-red badge badge-outline-daanger"
                @else
                    class="font-12 text-blue badge badge-outline-info"
                @endif
                >
                    {!! ucfirst($val->type) !!}
                </span>
            </td>
            <td>{!! date('d M Y',strtotime($val->created_at)) !!}</td>
            <td>
                <span class="font-12 badge badge-danger">
                    {!! $val->status !!}
                </span>
            </td>
            <td>
                <a class="btn btn-info text-white"
                    href="javascript:res_details('{{ $val?->id }}')">
                    {!! __('Details') !!}
                </a>
            </td>
        </tr>
    @endforeach
    <tbody>

    </tbody>
</table>
