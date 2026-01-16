@extends('admin.layouts.app')
@section('title'){!! __("Clinical Notes") !!} @endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="mt-0 header-title d-inline">@yield('title')</h4>

                <div class="pt-4">

                    @include('admin.clinical_notes._table')

                </div>

            </div>
        </div>
    </div>

    <div id="note_modal_container"></div>


@endsection

@push('scripts')
    <script>

       function note_details(id) {
            let url = "{{ route('admin.note_detail', ':id') }}";
            $.ajax({
                type: 'GET',
                url: url.replace(':id', id),
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    $('#note_modal_container').html('')
                    $('#note_modal_container').html(response)
                    $('#note_detail_modal').modal('show')
                },
                error: function(error) {}
            });
        };

    </script>
@endpush
