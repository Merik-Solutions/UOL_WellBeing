@extends('admin.layouts.app')
@section('title')
    {!! __('Payments') !!}
@endsection

@section('content')
    <style>
        .date {
            display: none;
        }
    </style>
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="mt-0 header-title d-inline">@yield('title')</h4>

                <form id="paymentFilter" class="" method="get" action="javascript:filterPayment()">
                    <div class="row justify-content-end">
                        <div class="date form-group col-md-2">
                            <input id="start_date" type="text" class="form-control" name="start_date"
                                placeholder="Start date" onfocus="(this.type='date')" onblur="(this.type='text')">
                        </div>

                        <div class="date form-group col-md-2">
                            <input id="end_date" type="text" class="form-control" name="end_date" placeholder="End date"
                                onfocus="(this.type='date')" onblur="(this.type='text')">
                        </div>

                        <div class="form-group col-md-2">
                            <select class="form-control" name="filter" id="filter">
                                <option value="All">All</option>
                                <option value="monthly">Monthly</option>
                                <option value="weekly">Weekly</option>
                                <option value="custom">Date range</option>
                            </select>
                        </div>

                        <div class="form-group col-1">
                            <button class="btn btn-primary waves-effect waves-light mr-1" type="submit">
                                {!! __('Search') !!}
                            </button>
                        </div>
                    </div>
                </form>

                <div id="payments_container">
                    <div class="">
                        <nav>
                            <div class="nav nav-tabs" id="payment-tab" role="tablist">
                                {{-- <a class="nav-item nav-link active" id="all_pay-tab" data-toggle="tab"
                                    href="#all_pay" role="tab" aria-controls="all_pay"
                                    aria-selected="false">{!! __("All Payments") !!}
                                    </a> --}}
                                <a class="nav-item nav-link active" id="pending_pay-tab" data-toggle="tab"
                                    href="#pending_pay" role="tab" aria-controls="pending_pay"
                                    aria-selected="true">{!! __('Pending') !!}
                                </a>
                                <a class="nav-item nav-link " id="disputed_pay-tab" data-toggle="tab" href="#disputed_pay"
                                    role="tab" aria-controls="disputed_pay" aria-selected="true">{!! __('Disputed') !!}
                                </a>
                                <a class="nav-item nav-link" id="paid_pay-tab" data-toggle="tab" href="#paid_pay"
                                    role="tab" aria-controls="paid_pay" aria-selected="false">{!! __('Paid') !!}
                                </a>

                            </div>
                        </nav>
                        <div class="tab-content" id="payment-tabContent">

                            {{-- <div class="tab-pane fade show active" id="all_pay" role="tabpanel"
                                    aria-labelledby="open--tab">
                                     @include('admin.payments._tables._all_payment_table')                                    
                                </div> 
                            --}}


                            <div class="tab-pane fade show active" id="pending_pay" role="tabpanel"
                                aria-labelledby="open--tab">
                                @include('admin.payments._tables._pending_payment_table')                               

                                <div id="payment_modal_container"></div>

                            </div>

                            <div class="tab-pane fade show " id="disputed_pay" role="tabpanel" aria-labelledby="open--tab">
                                @include('admin.payments._tables._disputed_payment_table')                                

                            </div>

                            <div class="tab-pane fade  " id="paid_pay" role="tabpanel" aria-labelledby="open--tab">
                                @include('admin.payments._tables._paid_payment_table')

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modal_container"></div>
@endsection

@push('scripts')
    <script>
        

        function doctor_payment_details(doctor_id, status,withdraw_id) {
            let url = "{{ url('admin/en/doctor_payment_details') }}" + '/' + doctor_id + '/status/' + status + '?withdraw_id='+withdraw_id;
            window.location.href = url;
        }

        // show custom date input for custom range dates filter
        $('#filter').change(function() {
            if ($(this).val() === 'custom') {
                $('.date').show();
            } else {
                $('.date').hide();
            }
        });

        // filter function payment
        function filterPayment() {

            let filter = $('#filter').val();
            let start_date = $('#start_date').val();
            let end_date = $('#end_date').val();

            if ((filter == 'custom') && (start_date == '' || end_date == '')) {
                alert('Please Select Both Dates...');
                return;
            }

            let data = new FormData($('#paymentFilter')[0]);

            $.ajax("{{ url('admin/en/filterPayments') }}", {
                method: 'post',
                processData: false,
                contentType: false,
                cache: false,
                data: data,
                success: function(response) {

                    $('#payments_container').html(response)
                },
                error: function(error) {}
            });

        }

        // on button click
        $(document).on('click', '.pay_money', function() {

            let filter = '';
            let start_date = '';
            let end_date = '';

            if ($(this).data('filter') === 'modal') {
                filter = 'custom';
                start_date = $('#fromDate').val();
                end_date = $('#toDate').val();
            } else {
                filter = $('#filter').val();
                start_date = $('#start_date').val();
                end_date = $('#end_date').val();
            }

            if ((filter == 'custom') && (start_date == '' || end_date == '')) {
                alert('Please Select Both Dates...');
                return;
            }

            let doctor_id = $(this).data('id');
            let url = "{{ url('admin/en/show_payment_modal') }}" + '/' + doctor_id;
            let data = new FormData();
            data.append('filter', filter);
            data.append('start_date', start_date);
            data.append('end_date', end_date);

            $.ajax({
                type: 'POST',
                enctype: 'multipart/form-data',
                url: url,
                data: data,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#payment_modal_container').html('')
                    $('#payment_modal').modal('hide');
                    $('.modal-backdrop').remove();
                    $('#payment_modal_container').html(response)
                    $('#payment_modal').modal('show')
                },
                error: function(error) {}
            });

        });

        // On to date change
        $(document).on('change', '#toDate', function() {

            let filter = '';
            let start_date = null;
            let end_date = '';

            if ($(this).data('filter') === 'modal') {
                filter = 'custom';
                start_date = $('#fromDate').val();
                end_date = $('#toDate').val();
            }
            if(start_date !== null && start_date > end_date){
                alert('From Date should be before To-Date');
                return;
            }

            let doctor_id = $(this).data('id');
            let url = "{{ url('admin/en/show_payment_modal') }}" + '/' + doctor_id;
            let data = new FormData();
            data.append('filter', filter);
            data.append('start_date', start_date);
            data.append('end_date', end_date);

            $.ajax({
                type: 'POST',
                enctype: 'multipart/form-data',
                url: url,
                data: data,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#payment_modal_container').html('')
                    $('#payment_modal').modal('hide');
                    $('.modal-backdrop').remove();
                    $('#payment_modal_container').html(response)
                    $('#payment_modal').modal('show')
                },
                error: function(error) {}
            });

        });

        // submit payment to doctor function
        $(document).on('click', '.pay_total_amount', function() {

            let start_date = $('#fromDate').val();
            let end_date = $('#toDate').val();
            let doctor_id = $(this).data('doctor');
            let commission = $('#commission').html();
            let total_without_commission = $('#total_without_commission').val();
            let amount = $('#total_payable').val();
            let transaction_id = $('#transaction_id').val();


            if (transaction_id == '') {
                alert('Please Enter Transaction ID');
                return;
            }
            if(start_date !== null && start_date > end_date){
                alert('From Date should be before To-Date');
                return;
            }
            if (end_date == '') {
                alert('Please Enter To-Date');
                return;
            }
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes, Proceed!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = "{{ url('admin/en/pay_total_amount') }}" + '/' + doctor_id;
                    let data = new FormData();

                    data.append('start_date', start_date);
                    data.append('end_date', end_date);
                    data.append('amount', amount);
                    data.append('bank_transaction_id', transaction_id);
                    data.append('commission', commission);
                    data.append('total_without_commission', total_without_commission);

                    $.ajax({
                        type: 'POST',
                        enctype: 'multipart/form-data',
                        url: url,
                        data: data,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            Swal.fire({
                                title: 'Successful',
                                text: response.message,
                                icon: 'success',
                                showCancelButton: false,
                                timer: 2000,
                                timerProgressBar: true,
                            })                           
                            setTimeout(() => {
                                window.location.reload();
                            }, 300);
                        },
                        error: function(error) {
                            Swal.fire({
                                title: 'Error!',
                                text: error.error,
                                icon: 'error',
                                showCancelButton: false,
                            })
                        }
                    });
                }

            })
        });

    </script>
@endpush
