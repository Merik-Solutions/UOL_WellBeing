<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>{!! __('Doctor') !!}</th>
            <th>{!! __('Patient') !!}</th>
            <th>{!! __('Day') !!}</th>
            <th>{!! __('From') !!}</th>
            <th>{!! __('To') !!}</th>
            {{-- <th>{!! __("prescription") !!}</th> --}}
            <th>{!! __('Date') !!}</th>
            @if ((($todays_tab ?? '') || (isset($reservations[0]) && $reservations[0]->status == 'active')) 
            && isset($reservations[0]->reservationCallLog) && $reservations[0]->reservationCallLog != null)
            <th>{!! __('Res-Status') !!}</th>
            @endif
            <th>{!! __('Status') !!}</th>
            @if (isset($reservations[0]) && $reservations[0]->status == 'finished')
                <th>{!! __('Call Record') !!}</th>
            @endif       
            @if (isset($reservations[0]) && $reservations[0]->status == 'finished' ||
                isset($reservations[0]) && $reservations[0]->status == 'active' ||
                isset($reservations[0]) && $reservations[0]->status == 'on_call'
                )
                <th style="padding-right:5px !important;">{!! __('Action') !!}</th>
            @endif

        </tr>
    </thead>
    <tbody>
        @php
            $today = Carbon\Carbon::now();
        @endphp
        @foreach ($reservations as $reservation)
            <tr>
                <td>{!! optional($reservation->doctor)->name !!}</td>
                <td>{!! optional($reservation->patient)->name !!}</td>
                <td>{!! $reservation->date !!}</td>
                <td>{!! Carbon\Carbon::parse($reservation->from_time)->format('H:i A') !!}</td>
                <td>{!! Carbon\Carbon::parse($reservation->to_time)->format('H:i A') !!}</td>
                {{-- <td>
                    <a class="btn btn-info text-white"
                    href="{!! route('admin.reservation.prescription.create',$reservation->id) !!}">
                        <i class="fas fa-stethoscope"></i>

                        {!! __("Prescription") !!}
                    </a>
                </td> --}}
                <td>{!! $reservation->created_at !!}</td>
                @if (($todays_tab ?? '' || $reservation->status == 'active') && $reservation?->reservationCallLog != null)
                <td>
                    @if ($reservation->date == $today->format('Y-m-d'))
                        @if (Carbon\Carbon::parse($reservation->from_time)->format('H:i A') < $today->format('H:i A') &&
                                Carbon\Carbon::parse($reservation->to_time)->format('H:i A') > $today->format('H:i A'))
                            <span class="font-weight-bold text-primary">
                                Due Now
                            </span>
                        @elseif(Carbon\Carbon::parse($reservation->to_time)->format('H:i A') < $today->format('H:i A'))
                            <span class="text-danger">
                                Past Due
                            </span>
                        @else
                            <span class="text-success">
                                Due Later
                            </span>
                        @endif
                    @elseif($reservation->date > $today->format('Y-m-d'))
                        <span class="text-success">
                            Due Later
                        </span>
                    @elseif($reservation->date < $today->format('Y-m-d') && $reservation->status == 'active')
                        <span class="text-danger">
                            Missed
                        </span>                        
                    @endif
                </td>
                @endif
                <td>
                    {!! $reservation->status !!}
                </td>
                @if ($reservation->status == 'active')
                    <td>
                        <a class="btn btn-danger text-white px-1 py-0"
                            href="javascript:cancelReservation('{{ $reservation->patient_id }}','{{ $reservation->id }}')">
                            {!! __('Cancel Reservation') !!}
                        </a>
                    </td>
                @endif
                @if ($reservation->status == 'on_call')
                    <td>
                        <a href="javascript:callLogDetails({{ $reservation->id }})"
                            class="btn btn-primary px-2 py-0">
                            <i class="fas fa-eye text-white"></i>
                        </a>   
                    </td>
                @endif                
                @if ($reservation->status == 'finished')
                    <td>
                        @if(count($reservation->videoCallRecord) < 1) 
                            <a href="javascript:void(0)"
                                class="btn btn-info px-2 py-0">
                                <i class="fas fa-file-video"></i>
                                No Recording
                            </a>                                
                        @else
                            <a href="javascript:showVideo('{{$reservation->id}}','{{ route('admin.get_call_recording',['id'=>$reservation->id])}}')"
                                class="btn btn-secondary px-2 py-0">
                                <i class="fas fa-file-video"></i>
                                View Recording
                            </a>  
                                
                        @endif
                    </td>
                    <td>
                        @if ($reservation->reservation_status == 'paid')
                            <span class="font-14 px-2 text-success badge" style="border: 1px solid #10c469;">Paid</span>                           
                        @else
                            @if ($reservation->reservation_status == 'disputed')
                                <span class="font-14 text-red badge badge-outline-daanger">Disputed</span>                               
                            @else
                                <a class="btn btn-danger text-white px-1 py-0"
                                    href="javascript:show_disputed_modal('{{ $reservation->id }}')">
                                    {!! __('Dispute ') !!}
                                </a>                                
                            @endif
                        @endif
                        <a href="javascript:callLogDetails({{ $reservation->id }})"
                            class="btn btn-primary px-1 py-0">
                            <i class="fas fa-eye text-white"></i>
                        </a> 
                    </td>
                @endif

                {{-- <td>
                    @component('admin.partials._action_buttons', ['routeName' => 'reservations', 'id' => $reservation->id, 'permission' => 'Reservation'])
                    @endcomponent
                </td> --}}
            </tr>
            @if($todays_tab ?? '')
                @php
                    $initiator = $reservation->reservationCallLog?->where('status', 'call_start')->last() ?? false;
                    $finished = $reservation->reservationCallLog?->where('status', 'call_end')->last() ?? false;
                    $rejected = $reservation->reservationCallLog?->where('status', 'call_rejected')->last()?? false;
                    $miss_res = $reservation->reservationCallLog?->where('status', 'call_missed')->last() ?? false;
                @endphp
                @if($rejected || $miss_res)                
                    <tr>
                        <td colspan="6">                        
                            @if($rejected)
                                <span class="text-danger">
                                    This Reservation call <b>rejected</b> by Patinet
                                </span> 
                            @else
                                <span class="text-warning">
                                    This Reservation call dose not <b>accepted</b>  by Patinet
                                </span>
                            @endif
                        </td>
                        <td colspan="3">
                            @if($rejected)
                            <span class="text-danger">
                                {{strtoupper($rejected->status)}}
                                </span> 
                            @else
                                <span class="text-warning">
                                    {{strtoupper($miss_res->status)}}
                                </span>
                            @endif
                        </td>
                    </tr>
                @elseif($finished)
                    <tr>
                        <td colspan="6">
                            <span class="text-success">
                                This Reservation call <b>finished</b> successfully finshed by {{$finished?->initiator == "App\Models\Doctor" ? "Doctor" :'Patinet'}}
                            </span>
                        </td>
                        <td colspan="3">
                            <span class="text-success">
                                {{strtoupper($finished?->status)}}
                            </span>
                        </td>
                    </tr>
                @elseif($reservation->status == 'active' && $reservation->date < $today->format('Y-m-d') ||
                    ($reservation->date == $today->format('Y-m-d') && Carbon\Carbon::parse($reservation->to_time)->format('H:i A') < $today->format('H:i A')))
                    <tr>
                        <td colspan="9">
                            <span class="text-danger">
                                This Reservation call <b>missed</b> by Doctor (did not called the patient)
                            </span>                           
                        </td>
                    </tr>
                @endif
            @endif
        @endforeach

    </tbody>
</table>
