<style>
    .table td {
        border-top: none !important;
        width: auto !important;
        padding-right: 60px !important;
    }

    .font_style {
        font-weight: 600 !important;
        font-size: 14px !important;
        color: #838383 !important;
        margin-right: 10px;
    }

    .font-14 {
        font-size: 14px !important;
        font-weight: 600 !important;
    }
</style>
<div class="modal fade bd-example-modal-lg" id="call_log_modal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Reservation Call Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                @if (count($call_logs) > 0)
                    <div class="row">
                        <div class="col-6">
                            <div class="pt-2 pl-4">
                                <div class="w-100 d-flex align-items-center">
                                    <div class="mr-2" style="width:50px; height:50px;">
                                        <img class="rounded-circle"
                                            src="{{ url($call_logs[0]->reservation?->doctor?->image) }}"
                                            alt="{{ $call_logs[0]->reservation?->doctor?->name }}"
                                            onerror="this.src='{!! asset('dashboard/logo.png') !!}'"
                                            style="width:100%; height:100%;" />
                                    </div>
                                    <div>
                                        <span class="text-blue">Doctor</span>
                                        <br>
                                        <span class="font_style">{{ $call_logs[0]->reservation?->doctor?->name }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="pt-2 pl-4">
                                <div class="w-100 d-flex align-items-center">
                                    <div class="mr-2" style="width:50px; height:50px;">
                                        <img class="rounded-circle"
                                            src="{{ url($call_logs[0]->reservation?->patient?->image) }}"
                                            alt="{{ $call_logs[0]->reservation?->patient?->name }}"
                                            onerror="this.src='{!! asset('dashboard/logo.png') !!}'"
                                            style="width:100%; height:100%;" />
                                    </div>
                                    <div>
                                        <span class="text-blue">Patient</span>
                                        <br>
                                        <span
                                            class="font_style">{{ $call_logs[0]->reservation?->patient?->name }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card-box">

                                <div class="row my-2 align-items-center">
                                    <div class="col-12">
                                        <h5>Reservation Details</h5>
                                        <table class="table">
                                            <tr>
                                                <td>Reservation-ID:</td>
                                                <td>{{ $call_logs[0]?->reservation_id ?? null }}</td>
                                                <td>Reservation From Time:</td>
                                                <td>{{ Carbon\Carbon::parse($call_logs[0]?->reservation?->from_time)->format('H:i:s A') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Reservation Date:</td>
                                                <td>{{ $call_logs[0]?->reservation->date ?? null }}</td>
                                                <td>Reservation To Time:</td>
                                                <td>{{ Carbon\Carbon::parse($call_logs[0]?->reservation?->to_time)->format('H:i:s A') }}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <h5>Call Details</h5>
                                <table class="table table-striped table-bordered   datatable-buttons">
                                    <thead>
                                        <tr>
                                            <th>{!! __('Date') !!}</th>
                                            <th>{!! __('Time') !!}</th>
                                            <th>{!! __('Initiator') !!}</th>
                                            <th>{!! __('Status') !!}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @php
                                        $start_time = 0;
                                        $end_time = 0;
                                        $duration = null;
                                    @endphp --}}
                                        @foreach ($call_logs as $call)
                                            {{-- @php
                                            // if ($call->status == \App\Models\UserDoctorCallLog::CALL_ACCEPTED) {
                                            //     if ($call[$loop->index - 1]->status == \App\Models\UserDoctorCallLog::CALL_START) {
                                            //         $start_time = \Carbon\Carbon::parse($call[$loop->index - 1]->time);
                                            //         print($start_time);
                                            //     }
                                            // }
                                            if ($call->status == \App\Models\UserDoctorCallLog::CALL_END) {
                                                if ($call[$loop->index]->status == \App\Models\UserDoctorCallLog::CALL_ACCEPTED) {
                                                    $start_time = \Carbon\Carbon::parse($call[$loop->index]->time);
                                                    $end_time = \Carbon\Carbon::parse($call->time);
                                                    $duration = $start_time->diff($end_time);
                                                }
                                            }
                                        @endphp --}}
                                            <tr>
                                                <td>{!! $call->date !!}</td>
                                                <td>{!! $call->time !!}</td>
                                                <td>
                                                    @if ($call->initiator == \App\Models\Doctor::class)
                                                        <span>Doctor</span>
                                                    @else
                                                        <span>Patient</span>
                                                    @endif
                                                </td>
                                                <td>{!! \Str::upper($call?->status) !!}</td>
                                            </tr>
                                            {{-- @if ($duration)
                                            <tr>
                                                @php
                                                    $hours = $duration->h < 10 ? '0' . $duration->h : $duration->h;
                                                    $mint = $duration->i < 10 ? '0' . $duration->i : $duration->i;
                                                    $sec = $duration->s < 10 ? '0' . $duration->s : $duration->s;
                                                @endphp
                                                <td><span class="font-14 text-blue"> Total Call Duration </span></td>
                                                <td colspan="3">
                                                    <span class="font-14 text-blue">
                                                        {{ $hours . ':' . $mint . ':' . $sec }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endif
                                        @php $duration = null; @endphp --}}
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <h5 class="text-danger">No call logs found!</h5>
                @endif
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn p-1 btn-danger" data-dismiss="modal">Close</button>
            </div> --}}
        </div>
    </div>
</div>
