@extends('admin.layouts.app')
@section('title') {!! __("Message Packages") !!} 
<style>
    .font-14 {
        font-size: 14px;
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
@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card-box">
            <h4 class="mt-0 header-title d-inline">@yield('title')</h4>
            <div class="pt-4">
                <nav>
                    <div class="nav nav-tabs" id="packages-tab" role="tablist">

                        <a class="nav-item nav-link active" id="active_packages-tab" data-toggle="tab"
                           href="#active_packages" role="tab" aria-controls="active_packages"
                           aria-selected="false">{!! __("Active packages") !!}
                        </a>

                        <a class="nav-item nav-link " id="expired_packages-tab" data-toggle="tab"
                           href="#expired_packages" role="tab" aria-controls="expired_packages"
                           aria-selected="true">{!! __("Expired packages") !!}
                        </a> 

                    </div>
                </nav>
                <div class="tab-content" id="packages-tabContent">

                    <div class="tab-pane fade show active" id="active_packages" role="tabpanel"
                         aria-labelledby="open-patients-tab">
                        @include('admin.message_packages._table',['packages'=>$active_packages])
                    </div>

                    <div class="tab-pane fade show " id="expired_packages" role="tabpanel"
                         aria-labelledby="open-patients-tab">
                        @include('admin.message_packages._expired_packages_table')
                    </div>
                    
                </div>
            </div>

            <div id="dispute_container">
                @include('admin.message_packages.modals.dispute_modal')                
            </div>

        </div>
    </div>
</div>

@endsection

@push('scripts')

<script>

    function show_disputed_modal(package_id){
          
        $('#package_id').val(package_id);
        $('#dispute_modal').modal('show')
            
    }

   function add_dispute(){
        let data = new FormData($('#add_dispute_form')[0]);
        $.ajax("{{url('admin/en/add_message_dispute')}}", {
            method: 'post',
            processData: false,
            contentType: false,
            cache: false,
            data: data,
            success: function(response) {
                console.log("Remarks added",response.message);
                $('#dispute_modal').modal('hide');
                Swal.fire({
                    title: 'Successful',
                    text: response.message,
                    icon: 'success',
                    showCancelButton: false,
                    timer: 2000,
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
   
</script>

@endpush
