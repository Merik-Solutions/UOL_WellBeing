@extends('admin.layouts.app')
@section('title')
    {!! __('Video Call Logs') !!}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="mt-0 header-title d-inline">@yield('title')</h4>
                <div class="pt-4">
                    <table class="table table-striped table-bordered   datatable-buttons">
                        <thead>
                            <tr>
                                <th>{!! __('Res-ID') !!}</th>
                                <th>{!! __('Doctor Image') !!}</th>
                                <th>{!! __('Doctor Name') !!}</th>
                                <th>{!! __('Patient Image') !!}</th>
                                <th>{!! __('Patient Name') !!}</th>
                                <th>{!! __('Date') !!}</th>
                                <th>{!! __('Time') !!}</th>
                                <th>{!! __('Status') !!}</th>
                                <th>{!! __('Actions') !!}</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($call_logs as $call)
                                <tr>
                                    <td>{{ $call->reservation_id }}</td>
                                    <td>
                                        @if ($call?->reservation?->doctor?->image)
                                            <a href="{{ url($call->reservation?->doctor?->image) }}" data-fancybox>
                                                <img class="rounded-circle" src="{{ url($call->reservation?->doctor?->image) }}" width="75"
                                                    height="75" alt="{{ $call->reservation?->doctor?->name }}"
                                                    onerror="this.src='{!! asset('dashboard/logo.png') !!}'" />
                                            </a>
                                        @else
                                            <img class="rounded-circle" src="{{ asset('dashboard/logo.png') }}" width="75" height="75" />
                                        @endif
                                    </td>
                                    <td>{!! $call->doctor->name !!}</td>

                                    <td>
                                        @if ($call?->reservation?->patient?->image)
                                            <a href="{{ url($call->reservation?->patient?->image) }}" data-fancybox>
                                                <img class="rounded-circle" src="{{ url($call->reservation?->patient?->image) }}" width="75"
                                                    height="75" alt="{{ $call->reservation?->patient?->name }}"
                                                    onerror="this.src='{!! asset('dashboard/logo.png') !!}'" />
                                            </a>
                                        @else
                                            <img class="rounded-circle" src="{{ asset('dashboard/logo.png') }}" width="100" height="100" />
                                        @endif
                                    </td>
                                    @if ($call->reservation?->patient->name != null)
                                        <td>{!! $call->reservation?->patient->name !!}</td>
                                    @else
                                        <td>{!! $call->reservation?->patient->phone !!}</td>
                                    @endif
                                    <td>{!! $call->date !!}</td>
                                    <td>{!! $call->time !!}</td>
                                    <td>{!!  \Str::upper($call->status) !!}</td>
                                    <td>
                                        <a href="javascript:callLogDetails({{ $call->reservation_id }})"
                                            class="btn btn-primary">
                                            <i class="fas fa-eye text-white"></i>
                                        </a>

                                    </td>
                                </tr>
                                
                            @endforeach
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>

    {{-- Call logs show modal --}}
    <div id="call_log_modal_container"></div>

    <script>
        function callLogDetails(id) {
            var url = "{{ route('admin.show_call_log', ':id') }}";
            $.ajax({
                type: 'GET',
                url: url.replace(':id', id),
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#call_log_modal_container').html('')
                    $('#call_log_modal_container').html(response)
                    $('#call_log_modal').modal('show')
                },
                error: function(error) {}
            });
        };
    </script>
@endsection
