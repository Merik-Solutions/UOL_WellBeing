@php $today = Carbon\Carbon::now(); @endphp
<table id="datatable-buttons" class="table table-striped table-bordered datatable-buttons">
    <thead>
        <tr>
            <th>{!! __("Doctor") !!}</th>
            <th>{!! __("Patient") !!}</th>
            <th>{!! __("Package") !!}</th>
            <th>{!! __("Purchased at") !!}</th>
            <th>{!! __("Expire at") !!}</th>
            <th>{!! __("Remarks") !!}</th>
            <th>{!! __('Status') !!}</th>
            <th>{!! __('Action') !!}</th>

        </tr>
    </thead>
    <tbody>
        @foreach($expired_packages as $package)
        @php
            $done_messages = $package->patient_messages_count;
            $total_package = $package->package_messages;
            $remaining = $total_package - $done_messages;
            $latest_msage = $package->latestMessage;         
        @endphp
        <tr>
            <td>{!! optional($package->doctor)->name !!}</td>
            <td>{!! optional($package->patient)->name !!}</td>
            <td>{!! optional($package->package)->name !!}</td>
            <td>{!! Carbon\Carbon::parse($package->created_at)->format('d M y g:i a')!!}</td>
            <td>{!! Carbon\Carbon::parse($package->expired_at)->format('d M y g:i a')!!}</td>
            <td style="width: 140px !important;">
                @if($package->expired_at > $today && $remaining > 0)
                    @if($latest_msage)
                        @php 
                            $message_by = explode('\\',$latest_msage?->sender_type)[2] == "User" ? 'patinet' : 'doctor';
                            $last_message_time = timeDiffInHours($latest_msage->seen_at,$today);
                            $time_diff = $latest_msage->seen_at->diffForHumans();
                        @endphp
                        @if($message_by == 'patinet' && $last_message_time > 11)
                            <span class="text-danger">Message not replayed by Doctor since {{ $time_diff}} </span>
                        @elseif($message_by == 'doctor' && $last_message_time > 11)
                            <span class="text-warning">Message not replayed by Patient since {{ $time_diff}}</span>
                        @else                        
                            <span>Last message did by {{$message_by }} {{ $time_diff}}</span>
                        @endif
                    @else                        
                        <span class="text-primary">Chat not initialized yet.</span>
                    @endif
                @elseif($package->expired_at < $today && $remaining > 0)
                    <span class="text-secondary">This package has been <span class="text-danger">Expired</span> 
                        and while having <b>{{$remaining }}</b> out of <b>{{$total_package}}</b> remaining message.
                    </span>
                @else
                    <span class="text-success">This package Successfully completed.</span>        
                @endif
            </td>
            <td>
                <span class="{{ $package->expired_at < $today ? 'text-danger' : 'text-success' }}">
                    {{ $package->expired_at < $today ? 'Expired' : 'Active' }}
                </span>
            </td>
            <td>
                @if($package->isPaid)
                    <span class="font-14 badge text-success">Paid</span>
                @else
                    @if($package->status == 'disputed')
                        <span class="font-14 text-red badge badge-outline-daanger">Disputed</span>
                    @else
                        <a class="btn btn-danger text-white px-1 py-0"
                            href="javascript:show_disputed_modal({{$package->id}})">
                            {!! __("Mark as disputed") !!}
                        </a>
                    @endif
                @endif                
            </td>
        </tr>
        @endforeach

    </tbody>
</table>

