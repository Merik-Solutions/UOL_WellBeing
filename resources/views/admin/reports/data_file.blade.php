<div id="name_logo" class="d-none">
    <div class="d-flex w-100 my-4" style="justify-content: space-between;align-items:flex-end;">
        <div style="padding-left: 10px;">
            <h3>KindaHealth</h3>
            <h5><span class="filter_name">Daily </span> Sale Report</h5>
        </div>
        <div id="date_div" class="d-none" style="padding: 5px;">
            <h5>
                From: <span id="start_date_div"></span>{{__(' ')}} To: <span id="end_date_div"></span>
            </h5>
        </div>
    </div>
</div>
<div class="row" style="padding: 5px;">
    <div class="col-xl-3 col-md-6">
        <div class="card-box">
            <h4 class="header-title mt-0 mb-3"><span class="filter_name">Daily</span> Sales Amount</h4>
            <div class="widget-box-2">
                <div class="widget-detail-2 text-right">
                    <span class="badge badge-primary badge-pill float-left mt-3">45.6% <i class="mdi mdi-trending-up"></i> </span>
                    <h2 class="font-weight-normal mb-1">{{$daily_sale}} </h2>
                    <p class="text-muted mb-3">Total Amount</p>
                </div>
                <div class="progress progress-bar-alt-success progress-sm">
                    <div class="progress-bar bg-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100"
                            aria-valuenow="100" style="width: 100%;">
                        <span class="sr-only">100% Complete</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card-box">
            <h4 class="header-title mt-0 mb-3">Sales Analytics</h4>
            <div class="widget-box-2">
                <div class="widget-detail-2 text-right">
                    <span class="badge badge-purple badge-pill float-left mt-3">{{$today_revenue}}% <i class="mdi mdi-trending-up"></i> </span>
                    <h2 class="font-weight-normal mb-1">{{$today_revenue}} </h2>
                    <p class="text-muted mb-3">Total Revenue</p>
                </div>
                <div class="progress progress-bar-alt-success progress-sm">
                    <div class="progress-bar bg-purple" role="progressbar" aria-valuemin="0" aria-valuemax="100"
                            aria-valuenow="100" style="width: 100%;">
                        <span class="sr-only">77% Complete</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card-box">
            <h4 class="header-title mt-0 mb-3">Sales Statistics</h4>
            <div class="widget-box-2">
                <div class="widget-detail-2 text-right">
                    <span class="badge badge-pink badge-pill float-left mt-3">33.3% <i class="mdi mdi-trending-up"></i> </span>
                    <h2 class="font-weight-normal mb-1">{{$total_amount}} </h2>
                    <p class="text-muted mb-3">Total Collected Amount</p>
                </div>
                <div class="progress progress-bar-alt-success progress-sm">
                    <div class="progress-bar bg-pink" role="progressbar" aria-valuemin="0" aria-valuemax="100"
                            aria-valuenow="100" style="width: 100%;">
                        <span class="sr-only">100% Complete</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card-box">
            <h4 class="header-title mt-0 mb-3">Transactions Statistics</h4>
            <div class="widget-box-2">
                <div class="widget-detail-2 text-right">
                    <span class="badge badge-success badge-pill float-left mt-3">{{$total_transactions}}% <i class="mdi mdi-trending-up"></i> </span>
                    <h2 class="font-weight-normal mb-1">{{$total_transactions}} </h2>
                    <p class="text-muted mb-3">Total Transactions</p>
                </div>
                <div class="progress progress-bar-alt-success progress-sm">
                    <div class="progress-bar bg-success" role="progressbar" aria-valuemin="0" aria-valuemax="100"
                            aria-valuenow="100" style="width: 100%;">
                        <span class="sr-only">100% Complete</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card-box">
            <h4 class="header-title mt-0 mb-3">Transactions List</h4>
            <table id="datatable-buttons" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Id#</th>
                        <th>Sender</th>
                        <th>Receiver</th>
                        <th>Pay For</th>
                        <th>Receiver amount</th>
                        <th>App Commission</th>
                        <th>Service Charges</th>
                        <th>VAT</th>
                        <th>Total</th>
                        <th>gateway</th>
                        <th>Invoice Id</th>
                        <th>Description</th>
                        <th>Date</th>
            
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>{!! $transaction->id !!}</td>            
                            <td>{!! $transaction->sender->name??$transaction->sender->phone??'no name' !!}</td>
                            <td>{!! $transaction->receiver->name??'no name' !!}</td>
                            <td>{!! $transaction->billable_type??'n/a' !!}</td>
                            <td>{!! number_format($transaction->amount??0.00,2) !!}</td>
                            <td>{!! number_format($transaction->commission??0.00,2) !!}</td>
                            <td>{!! number_format($transaction->commission+$transaction->amount,2) !!}</td>
                            <td>{!! number_format($transaction->vat_tax??0.00,2) !!}</td>
                            <td>{!! number_format($transaction->total??0.00,2) !!}</td>
                            <td>{!! $transaction->gateway??'-' !!}</td>
                            <td>{!! $transaction->invoice_id??'n/a' !!}</td>
                            <td>{!! $transaction->description??'null' !!}</td>
                            <td>{!! $transaction->created_at !!}</td>
            
                        </tr>
                    @endforeach            
                </tbody>
            </table>
        </div>
    </div>

    

</div>