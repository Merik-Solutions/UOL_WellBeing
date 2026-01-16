<!--  Modal content for the above example -->
<div id="call-recording-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Reservation# <span
                        class="text-blue">{{ $reservation->id }}</span> - Call Recording</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" style="min-height: 500px;">
                <div class="row">
                    <div class="col-12">
                        <div style="height: 400px;">
                            <video id="call_recording_show" class="h-100 w-100 bg-dark"
                                src="{{ showCallRecording($videos[0]) }}" controls autoplay></video>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row mt-3 gap-2">
                            @if (is_array($videos) && count($videos) > 1)
                                @foreach ($videos as $key => $video)
                                    <div class="col">
                                        <button data-url="{{ showCallRecording($video) }}"
                                            class="recording-data btn btn-secondary w-100"> Call
                                            {{ $loop->iteration }}</button>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-12">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <span class="text-blue"><b>Doctor Name</b></span>
                            <br>
                            <span>{{ $reservation->doctor->name_en ?? ($reservation->doctor->name_ar ?? 'Dr.') }}</span>
                        </div>
                        <div>
                            <span class="text-blue"><b>Patinet Name</b></span>
                            <br>
                            <span>{{ $reservation?->patient?->name ?? $reservation?->patient?->phone }}</span>
                        </div>
                        <div>
                            <span class="text-blue"><b>Reservation Date/Time</b></span>
                            <br>
                            <span>{{ $reservation->date }}</span>
                            <span>{{ $reservation->from_time }}</span>
                        </div>

                    </div>
                </div>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
