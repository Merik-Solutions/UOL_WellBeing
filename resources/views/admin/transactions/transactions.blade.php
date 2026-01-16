@extends('admin.layouts.app')
@section('title')
    {!! __('Transactions') !!}
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

                <form id="" method="get" action="javascript:void(0)">
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
                            <button class="btn btn-primary waves-effect waves-light mr-1" type="button" onclick="dateFilter()">
                                {!! __('Search') !!}
                            </button>
                        </div>
                    </div>
                </form>

                <div class="pt-2">
                    <form>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="gender">{!! __('Doctor') !!} </label>
                                {!! Form::select('doctor_id', $doctors, null, [
                                    'class' => 'form-control select2',
                                    'id' => 'doctor_id',
                                    'placeholder' => __('Select Doctor'),
                                ]) !!}
                            </div>


                            <div class="form-group col-md-3">
                                <label for="gender">{!! __('Patient') !!} </label>
                                {!! Form::select('user_id', $users, null, [
                                    'class' => 'form-control select2',
                                    'id' => 'patient_id',
                                    'placeholder' => __('Select Patient'),
                                ]) !!}
                            </div>

                            <div class="form-group col-md-3">
                                <label for="gender">{!! __('Category') !!} </label>
                                {!! Form::select('category_id', $categories, null, [
                                    'class' => 'form-control select2',
                                    'id' => 'category_id',
                                    'placeholder' => __('Select Category'),
                                ]) !!}
                            </div>
                            <div class="form-group col-2  mt-3 p-1">
                                <button class="btn btn-primary waves-effect waves-light mr-1" type="button" onclick="transactions_table()">
                                    {!! __('Search') !!}
                                </button>
                            </div>


                        </div>

                    </form>

                    <div id="transaction_div">
                        @include('admin.transactions._table')

                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection


@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        transactions_table();
    });

    // show custom date input for custom range dates filter
    $('#filter').change(function() {
        if ($(this).val() === 'custom') {
            $('.date').show();
        } else {
            $('.date').hide();
        }
    });

    function dateFilter() {
        let filter = $('#filter').val()??null;
        let start_date = $('#start_date').val()??null;
        let end_date = $('#end_date').val()??null;

        if ((filter == 'custom') && (!start_date || !end_date)) {
            alert('Please Select Both Dates...');
            return;
        }
        if(filter == 'All'){
            window.location.href = "{{route('admin.transactions')}}";
        }
        var data = {
            'type': filter,
            'start_date': start_date,
            'end_date': end_date
        };

        transactions_table(data);

    }

    function transactions_table(data=null){
        var dataTable = $('#transactions_table').DataTable();
        dataTable.destroy(); 
        doctor_id = $('#doctor_id').val()??null;
        user_id = $('#patient_id').val()??null;
        category_id = $('#category_id').val()??null;
        if(!data){
            data = {
                'doctor_id' : doctor_id,
                'user_id' : user_id,
                'category_id' : category_id,
            }  
        }
        table = $('#transactions_table').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            deferRender: true,
            cache:false,
            ajax: {
                url: "{{ route('admin.get_transactions') }}",
                type: 'get',
                dataType: 'json',
                data: data,
            },
            columnDefs: [
                {
                    targets: 0,
                    data: 'id',
                    render: function (data, type, row, meta) {
                        return row.id; 
                    }
                },
                {
                    targets: 1,
                    render: function (data, type, row, meta) {
                        return row?.sender?.name ?? row?.sender?.phone ??'--'; 
                    }
                },
                {
                    targets: 2,
                    render: function (data, type, row, meta) {
                        return row?.receiver?.name_en??'--';
                    }
                },
                {
                    targets: 3,
                    render: function (data, type, row, meta) {
                        return row.billable_type??'--';
                    }
                },
                {
                    targets: 4,
                    render: function (data, type, row, meta) {
                        return parseFloat(row.amount).toFixed(2);
                    }
                },
                {
                    targets: 5,
                    render: function (data, type, row, meta) {
                        return parseFloat(row.commission??0.00).toFixed(2);
                    }
                },
                {
                    targets: 6,
                    render: function (data, type, row, meta) {
                        return (parseFloat(row.commission??0.00) + parseFloat(row.amount??0.00)).toFixed(2);
                    }
                },
                {
                    targets: 7,
                    render: function (data, type, row, meta) {
                        return parseFloat(row.vat_tax??0.00).toFixed(2);
                    }
                },
                {
                    targets: 8,
                    render: function (data, type, row, meta) {
                        return parseFloat(row.total??0.00).toFixed(2);
                    }
                },
                {
                    targets: 9,
                    render: function (data, type, row, meta) {
                        return row.gateway??'--';
                    }
                },
                {
                    targets: 10,
                    render: function (data, type, row, meta) {
                        return row.invoice_id??'--';
                    }
                },
                {
                    targets: 11,
                    render: function (data, type, row, meta) {
                        return row.description??'--';
                    }
                },
                {
                    targets: 12,
                    render: function (data, type, row, meta) {
                        var date = new Date(row.created_at);
                        return date.toLocaleString('en-US', options).replace(/\//g, '-');
                    }
                },
            ]
        })
    }

    // Create an options object for formatting
    var options = {
        year: 'numeric',
        day: '2-digit',
        month: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false
    };


</script>
@endpush
