<table id="datatable-buttons" class="table table-striped table-bordered  ">
    <thead>
    <tr>
        {{-- <th>{!! __("#") !!}</th> --}}
        <th>{!! __("Patient") !!}</th>
        <th>{!! __("Doctor") !!}</th>
        <th>{!! __("Disputable Id") !!}</th>
        <th>{!! __("Disputed Type") !!}</th>
        <th>{!! __("Type") !!}</th>
        <th>{!! __("Lodged On") !!}</th>
        <th>{!! __("Status") !!}</th>
        <th>{!! __('Actions') !!}</th>

    </tr>
    </thead>
    <tbody>
        @foreach($disputes->sortDesc() as $val)
            <tr>
                {{-- <td>{!! $loop->iteration !!}</td> --}}
                <td>{!! $val?->patient?->name? : 'n/a' !!}</td>
                <td>{!! $val?->doctor?->name_en? :'n/a' !!}</td>
                <td>{!! $val?->disputed_id? : '' !!}</td>
            <td>{!! $val?->disputed_type? : '' !!}</td>
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
                    <span
                    @if($val->status == App\Models\ComplaintOrFeedback::STATUS_RESOLVED)
                        class="font-12 badge badge-success"
                    @elseif($val->status == App\Models\ComplaintOrFeedback::STATUS_INVESTIGATE)
                        class="font-12 badge badge-warning"
                    @else
                        class="font-12 badge badge-danger"
                    @endif
                    >{!! $val->status !!}</span>
                </td>
                <td>
                    <a class="btn btn-info text-white"
                        href="javascript:res_details('{{ $val?->id }}')">
                        {!! __('Details') !!}
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
