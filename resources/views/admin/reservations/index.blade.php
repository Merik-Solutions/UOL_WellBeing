@extends('admin.layouts.app')
@section('title')
    {!! __('Reservations') !!}
@endsection

@section('content')
    <style>
        .font-14 {
            font-size: 14px;
        }

        .badge-outline-daanger {
            border: 1px solid red;
        }

        .badge-outline-info {
            border: 1px solid #17a2b8;
        }

        .text-red {
            color: red;
        }
    </style>
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="mt-0 header-title d-inline">@yield('title')</h4>
                {{-- @can('Create Reservation')
            <div class="mt-0 header-title float-right  d-inline">

                <a class="btn btn-info text-white" href="{!! route('admin.reservations.create') !!}">
                    <i class="fas fa-plus"></i> {!! __("New")!!}</a>
            </div>
            @endcan --}}
                <div class="pt-4">

                    <nav>
                        <div class="nav nav-tabs" id="reservations-tab" role="tablist">


                            <a class="nav-item nav-link active" id="todays_reservations-tab" data-toggle="tab"
                                href="#todays_reservations" role="tab" aria-controls="todays_reservations"
                                aria-selected="false">{!! __('Today Reservations') !!}
                            </a>

                            <a class="nav-item nav-link" id="active_reservations-tab" data-toggle="tab"
                                href="#active_reservations" role="tab" aria-controls="active_reservations"
                                aria-selected="false">{!! __('Active Reservations') !!}
                            </a>

                            <a class="nav-item nav-link" id="no_show_reservations-tab" data-toggle="tab"
                                href="#no_show_reservations" role="tab" aria-controls="no_show_reservations"
                                aria-selected="false">{!! __('No Show Reservations') !!}
                            </a>


                            <a class="nav-item nav-link " id="accepted_reservations-tab" data-toggle="tab"
                                href="#accepted_reservations" role="tab" aria-controls="accepted_reservations"
                                aria-selected="true">{!! __('Accepted Reservation') !!}
                            </a>


                            {{-- <a class="nav-item nav-link " id="refused_reservations-tab" data-toggle="tab"
                                href="#refused_reservations" role="tab" aria-controls="accepted_reservations"
                                aria-selected="true">
                                {!! __("Refused Reservations") !!}
                            </a> --}}

                            <a class="nav-item nav-link" id="canceled-reservations-tab" data-toggle="tab"
                                href="#canceled_reservations" role="tab" aria-controls="canceled_reservations"
                                aria-selected="false">{!! __('Canceled Reservations') !!}
                            </a>

                            <a class="nav-item nav-link" id="finished_reservations-tab" data-toggle="tab"
                                href="#finished_reservations" role="tab" aria-controls="finished_reservations"
                                aria-selected="false">{!! __('Finished Reservations') !!}
                            </a>

                        </div>
                    </nav>
                    <div class="tab-content" id="reservations-tabContent">

                        <div class="tab-pane fade show active" id="todays_reservations" role="tabpanel"
                            aria-labelledby="open-patients-tab">
                            @include('admin.reservations._table', [
                                'reservations' => $todays_reservations,
                                'todays_tab' => true,
                            ])
                        </div>

                        <div class="tab-pane fade show" id="active_reservations" role="tabpanel"
                            aria-labelledby="open-patients-tab">
                            @include('admin.reservations._table', ['reservations' => $active_reservations])
                        </div>

                        <div class="tab-pane fade show" id="no_show_reservations" role="tabpanel"
                            aria-labelledby="open-patients-tab">
                            @include('admin.reservations._table', [
                                'reservations' => $no_show_reservations,
                            ])
                        </div>


                        <div class="tab-pane fade show" id="accepted_reservations" role="tabpanel"
                            aria-labelledby="open-patients-tab">
                            @include('admin.reservations._table', [
                                'reservations' => $accepted_reservations,
                            ])
                        </div>


                        {{-- <div class="tab-pane fade  " id="refused_reservations" role="tabpanel"
                            aria-labelledby="open-patients-tab">
                            @include('admin.reservations._table',['reservations'=>$refused_reservations])
                        </div> --}}


                        <div class="tab-pane fade  " id="canceled_reservations" role="tabpanel"
                            aria-labelledby="open-patients-tab">
                            @include('admin.reservations._table', [
                                'reservations' => $canceled_reservations,
                            ])
                        </div>

                        <div class="tab-pane fade  " id="finished_reservations" role="tabpanel"
                            aria-labelledby="open-patients-tab">
                            @include('admin.reservations._table', [
                                'reservations' => $finished_reservations,
                            ])
                        </div>


                    </div>

                </div>

                <div id="dispute_container">
                    @include('admin.reservations.modals.dispute_modal')
                </div>
                <div id="recording_container">
                    {{-- @include('admin.reservations.modals.call_recording') --}}
                </div>

            </div>
        </div>
    </div>

    <div id="call_log_modal_container"></div>
@endsection

@push('scripts')
    <script>
        function cancelReservation(patient_id, res_id) {
            let url = "{{ url('admin/en/reservation_cancel') }}" + '/' + patient_id + '/' + res_id;

            Swal.fire({
                title: 'Are you sure?',
                text: 'Cancel this Reservation!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: 'GET',
                        url: url,
                        processData: false,
                        contentType: false,
                        cache: false,
                        success: function(response) {
                            if (response.error) {
                                Swal.fire({
                                    title: 'Error',
                                    text: response.message,
                                    icon: 'error',
                                    showCancelButton: false,

                                })
                            } else {
                                Swal.fire({
                                    title: 'Successful',
                                    text: response.message,
                                    icon: 'success',
                                    showCancelButton: false,
                                    timerProgressBar: true,
                                }).then(() => {
                                    location.reload()
                                })
                            }
                        },
                        error: function(error) {
                            Swal.fire({
                                title: 'Error',
                                text: error.message,
                                icon: 'error',
                                showCancelButton: false,

                            })
                        }
                    });
                }
            });

        }

        function show_disputed_modal(reservation_id) {

            $('#reservation_id').val(reservation_id);
            $('#dispute_modal').modal('show')

        }

        function add_dispute() {
            let data = new FormData($('#add_dispute_form')[0]);

            let url = "{{ route('admin.add_dispute') }}";
            $.ajax(url, {
                method: 'post',
                processData: false,
                contentType: false,
                cache: false,
                data: data,
                success: function(response) {
                    console.log("Remarks added", response.message);
                    $('#dispute_modal').modal('hide');
                    Swal.fire({
                        title: 'Successful',
                        text: response.message,
                        icon: 'success',
                        showCancelButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                    }).then(() => {
                        location.reload()
                    })
                },
                error: function(error) {
                    Swal.fire({
                        title: 'Error',
                        text: error.message,
                        icon: 'error',
                        showCancelButton: false,

                    })
                }
            });
        }

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

        // function showVideo(res_id, route) {
        //     $('#recording_container').html('');

        //     $.ajax(route, {
        //         method: 'get',
        //         processData: false,
        //         contentType: false,
        //         cache: false,
        //         success: function(response) {
        //             $('#recording_container').html(response)
        //             $('#call-recording-modal').modal('show')
        //         },
        //         error: function(error) {
        //             Swal.fire({
        //                 title: 'Error',
        //                 text: error.message,
        //                 icon: 'error',
        //                 showCancelButton: false
        //             })
        //         }
        //     });
        // }

        function showVideo(res_id, route) {
            // Empty the modal content
            $('#recording_container').html('');

            $.ajax(route, {
                method: 'get',
                processData: false,
                contentType: false,
                cache: false,
                success: function(response) {
                    // Insert the response HTML into the modal content
                    $('#recording_container').html(response);

                    // Show the modal
                    $('#call-recording-modal').modal('show');

                    // Attach an event handler to the modal's hidden event
                    $('#call-recording-modal').on('hidden.bs.modal', function(e) {
                        // Get the video element
                        var videoElement = document.getElementById('call_recording_show');

                        // Pause the video
                        videoElement.pause();

                        // Reset the video source to stop playback
                        videoElement.src = '';
                    });

                    // Attach an event handler to the modal's shown event
                    $('#call-recording-modal').on('shown.bs.modal', function(e) {
                        // Check if videosData is set
                        if (typeof videosData !== 'undefined' && videosData.length > 0) {
                            // Set the video source when the modal is shown
                            var videoElement = document.getElementById('call_recording_show');
                            videoElement.src = videosData[0]
                                .video_url; // Replace with your actual property

                            // Play the video
                            videoElement.play();
                        }
                    });
                },
                error: function(error) {
                    Swal.fire({
                        title: 'Error',
                        text: error.message,
                        icon: 'error',
                        showCancelButton: false
                    });
                }
            });
        }


        $(document).on('click', '.recording-data', function() {

            let dataUrl = $(this).attr('data-url');
            let videoTag = $('#call_recording_show');
            videoTag.prop('src', dataUrl);
        })
    </script>
@endpush
