@extends('admin.layouts.app')
@section('title')
    {!! __('Sales Report') !!}
@endsection
@section('content')
    <style>
        .date {
            display: none;
        }
    </style>
    <div class="row">
        <div class="col-12">
            <form id="transactionFilter" method="get" action="javascript:filterTransaction()">
                <div class="row justify-content-end">
                    <div class="date form-group col-md-2">
                        <input id="start_date" type="text" class="form-control" name="start_date" placeholder="Start date"
                            onfocus="(this.type='date')" onblur="(this.type='text')">
                    </div>
                    <div class="date form-group col-md-2">
                        <input id="end_date" type="text" class="form-control" name="end_date" placeholder="End date"
                            onfocus="(this.type='date')" onblur="(this.type='text')">
                    </div>
                    <div class="form-group col-md-2">
                        <select class="form-control" name="type" id="type">
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                            <option value="yearly">Yearly</option>
                            <option value="custom">Date Range</option>
                        </select>
                    </div>
                    <div class="d-flex">
                        <button class="btn btn-primary waves-effect waves-light mr-1" type="submit" style="height: 36px;">
                            {!! __('Filter') !!}
                        </button>
                        <button class="btn btn-secondary waves-effect waves-light mr-1" type="button" onclick="printPageArea('data_section_div')" style="height: 36px;">
                            {!! __('Print') !!}
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <div id="data_section_div">
        @include('admin.reports.data_file')
    </div>
@endsection
@push('scripts')
    <script>
        $(document).on('change', '#filter', function() {
            let type = $(this).val();
            if (type == 'custom') {
                $('.date').show();
            } else {
                $('.date').hide();
            }
        })

        function filterTransaction() {
            let type = $('#type').val();
            let start_date = $('#start_date').val();
            let end_date = $('#end_date').val();
            console.log(type);

            if ((type == 'custom') && (start_date == '' || end_date == '')) {
                alert('Please Select Both Dates...');
                return;
            }
            let data = new FormData($('#transactionFilter')[0]);          
            $.ajax({
                method: 'post',
                url: "{!! route('admin.filter_reports') !!}",
                processData: false,
                contentType: false,
                cache: false,
                data: data,
                success: function(res) {
                    if(res.status){
                        $('#data_section_div').html('')
                        $('#data_section_div').html(res.html)
                        $('.filter_name').text('');
                        $('.filter_name').text(filter.charAt(0).toUpperCase() + filter.slice(1));
                        if(filter == 'custom'){
                            let date_div = document.getElementById('date_div');
                            date_div.classList.remove("d-none");
                            $('#start_date_div').text('');
                            $('#end_date_div').text('');
                            $('#start_date_div').text(start_date);
                            $('#end_date_div').text(end_date);
                                                        

                        }
                    }else{
                        alert('Action failed!.')
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });

        }

        function printPageArea(areaID){
            let name_logo = document.getElementById('name_logo');
            name_logo.classList.remove("d-none");
            var printContent = document.getElementById(areaID).innerHTML;
            var originalContent = document.body.innerHTML;
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalContent;
            removeDiv()
           
        }

        function removeDiv()
        {
            let name_logo = document.getElementById('name_logo');
            name_logo.classList.add("d-none");
        }
    </script>
@endpush
