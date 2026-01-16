@extends('admin.layouts.app')
@section('title')
    {!! __('Prescriptions') !!}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="mt-0 header-title d-inline">@yield('title')</h4>
                <div class="pt-4">
                    <table id="datatable-buttons" class="table table-striped table-bordered  ">
                        <thead>
                            <tr>
                                <th>{!! __('Doctor') !!}</th>
                                <th>{!! __('Patient') !!}</th>
                                <th>{!! __('Code') !!}</th>
                                <th>{!! __('Diagnosis') !!}</th>
                                <th>{!! __('Description') !!}</th>
                                <th>{!! __('Date') !!}</th>
                                <th>{!! __('Action') !!}</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prescriptions as $prescript)
                                <tr>
                                    <td>{!! optional($prescript->doctor)->name !!}</td>
                                    <td>{!! optional($prescript->patient)->name !!}</td>
                                    <td>{!! $prescript->code ?? '' !!}</td>
                                    <td>{!! $prescript->diagnosis ?? '' !!}</td>
                                    <td>{!! Str::of($prescript?->description ?? '')->words(3, ' ...') !!}</td>
                                    <td>{!! date('d M Y g:i a', strtotime($prescript?->created_at ?? '--:--:--')) !!}</td>
                                    <td>
                                        <a href="{{route('printPrescription',[$prescript?->id])}}" class="btn btn-secondary text-white"
                                            target="_blank"
                                            >
                                            <i class="fas fa-print text-white"></i>
                                        </a>
                                        {{-- <button class="btn btn-primary text-white"
                                            onclick="printPrescript({{ $prescript?->id }})">
                                            {!! __('Print') !!}
                                        </button> --}}
                                        <button class="btn btn-info text-white"
                                            onclick="prescript_details({{ $prescript?->id }})">
                                            {!! __('Details') !!}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>




                </div>

            </div>
        </div>
    </div>

    <div id="prescription_modal_container"></div>
@endsection

@push('scripts')
    <script>
        function prescript_details(id) {
            let url = "{{ route('admin.prescription_details', ':id') }}";
            $.ajax({
                type: 'GET',
                url: url.replace(':id', id),
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    $('#prescription_modal_container').html('')
                    $('#prescription_modal_container').html(response)
                    $('#prescription_detail_modal').modal('show')
                },
                error: function(error) {}
            });
        };


        // function printPrescript(id) {
        //     let url = "{{ route('printPrescription', ':id') }}";
        //     url = url.replace(':id', id);
        //     console.log(url);
        //     $.ajax({
        //         type: 'GET',
        //         url: url,
        //         contentType: false,
        //         processData: false,
        //         cache: false,
        //         success: function(response) {
        //             console.log(response);
        //             swal.fire('Success', 'Prescription printed', 'success');
        //         },
        //         error: function(error) {
        //             console.log(error);
        //         }
        //     });
        // };
    </script>
@endpush
