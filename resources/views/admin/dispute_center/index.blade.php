@extends('admin.layouts.app')
@section('title')
    {!! __('Dispute Center') !!}
@endsection

@section('content')
<style>
    .font-12 {
        font-size: 12px;
    }
    .badge-outline-daanger{
        border: 1px solid red;
    }
    .badge-outline-info{
        border: 1px solid #17a2b8;
    }
    .text-red{
        color: red;
    }
</style>
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="mt-0 header-title d-inline">@yield('title')</h4>
                
                <div class="pt-4">
                    <nav>
                        <div class="nav nav-tabs" id="dispute-tab" role="tablist">

                            <a class="nav-item nav-link active" id="all_dispute-tab" data-toggle="tab"
                                href="#all_dispute" role="tab" aria-controls="all_dispute"
                                aria-selected="true">{!! __('All') !!}
                            </a>
                            <a class="nav-item nav-link" id="pending_dispute-tab" data-toggle="tab"
                                href="#pending_dispute" role="tab" aria-controls="pending_dispute"
                                aria-selected="true">{!! __('Pending') !!}
                            </a>
                            <a class="nav-item nav-link " id="investigation_dispute-tab" data-toggle="tab" href="#investigation_dispute"
                                role="tab" aria-controls="investigation_dispute" aria-selected="true">{!! __('Investigation') !!}
                            </a>
                            <a class="nav-item nav-link" id="resolved_dispute-tab" data-toggle="tab" href="#resolved_dispute"
                                role="tab" aria-controls="resolved_dispute" aria-selected="false">{!! __('Resolved') !!}
                            </a>

                        </div>
                    </nav>
                    <div class="tab-content" id="dispute-tabContent">

                        <div class="tab-pane fade show active" id="all_dispute" role="tabpanel"
                            aria-labelledby="open--tab">
                            @include('admin.dispute_center._tables._table',['disputes' => $all_disputes])
                            
                        </div>
                        <div class="tab-pane fade show" id="pending_dispute" role="tabpanel"
                            aria-labelledby="open--tab">
                            @include('admin.dispute_center._tables._table',['disputes' => $pending])
                            
                        </div>

                        <div class="tab-pane fade show " id="investigation_dispute" role="tabpanel" aria-labelledby="open--tab">
                            @include('admin.dispute_center._tables._table',['disputes' => $investigation])
                        </div>

                        <div class="tab-pane fade  " id="resolved_dispute" role="tabpanel" aria-labelledby="open--tab">
                            @include('admin.dispute_center._tables._table',['disputes' => $resolved])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="dispute_modal_container"></div>
   
@endsection

@push('scripts')
    <script>

       function res_details(id) {
        var url = "{{ route('admin.show_res_detail', ':id') }}";
            $.ajax({
                type: 'GET',
                enctype: 'multipart/form-data',
                url: url.replace(':id', id),
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#dispute_modal_container').html('')
                    $('#dispute_modal_container').html(response)
                    $('#dispute_detail_modal').modal('show')
                },
                error: function(error) {}
            });
        };

        function disputRemarks() {        
            let data = new FormData($('#addComplaintOrFeedbackRemarks')[0]);

            if(!data.get('status')){
                alert('Please select status.')
                return false
            }else{

                $.ajax("{{url('admin/en/addComplaintOrFeedbackRemarks')}}", {
                    method: 'post',
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: data,
                    success: function(response) {
                        $('#dispute_detail_modal').modal('hide');
                        $('.modal-backdrop').remove();
                        if(response.error){
                            var text = 'Error'; 
                            var icon = 'error';
                        }
                        Swal.fire({
                            title: text ?? 'Successful',
                            text: response.message,
                            icon: icon ?? 'success',
                            showCancelButton: false,
                            timerProgressBar: true,
                        }).then(() =>{location.reload()})
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

        }

        function closeModal(){
            $('#remarks_history').modal('hide');
        }
        


    </script>
@endpush
