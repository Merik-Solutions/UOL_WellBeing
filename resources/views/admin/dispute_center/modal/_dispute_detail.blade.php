<style>
    .table td {
        border-top: none !important;
        width: auto !important;
        padding-right: 60px !important;
    }

    .font_style {
        font-weight: 600 !important;
        font-size: 14px !important;
        color: #838383 !important;
        margin-right: 10px;
    }
    .font-14 {
        font-size: 14px !important;
    }
</style>
<div class="modal fade bd-example-modal-xl" id="dispute_detail_modal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addComplaintOrFeedbackRemarks" method="Post" action="javascript:disputRemarks()">
                <div class="modal-body">
                    <input type="hidden" name="complaint_id" value="{{ $resDetail?->id }} ">
                    <input type="hidden" name="disputed_type" value="{{ $resDetail->disputed_type == 'package' ? 'package' : 'reservation' }} ">
                    <div class="row">
                        <div class="col-md-7 pt-2 px-3">
                            <div class="row" style="padding-top: 10px;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Type</label>
                                        <p class="form-control border-0 rounded">
                                            {{ Str::ucfirst($resDetail?->type ?? 'n/a') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group text-right">
                                        <label for="">Lodged On</label>
                                        <p class="form-control border-0 rounded pr-0">
                                            {{ $resDetail?->created_at ? date('d M Y g:i a', strtotime($resDetail?->created_at ?? '')) : '--:--:--' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="">Description</label>
                               <p class="form-control border-0 rounded" style="height: auto;">
                                    {{ $resDetail?->description ?? 'No description given' }}
                                </p>

                            </div>
                            <div class="form-group">
                                <label for="">Add Remarks</label>
                                <textarea class="form-control text-left bg-light border-0 rounded" name="remarks" required></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Status</label>
                                        <select class="form-control bg-light border-0 rounded" name="status" required="required">
                                            <option disabled selected>Select status</option>
                                            <option value="pending">Pending</option>
                                            <option value="under-investigation">Under Investigation</option>
                                            <option value="resolved">Resolved</option>
                                        </select>                               
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Penalize the Doctor <code style="color: red;">in(%)</code></label>
                                        <div class="input-group">
                                            <input type="number" class="form-control bg-light border-0 rounded" name="penalty">
                                            <div class="input-group-append">
                                              <span class="input-group-text border-0">%</span>
                                              {{-- <span class="input-group-text">0.00</span> --}}
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-between">
                                        <h4>Remarks</h4>
                                        <span>{{ date('d M Y g:i a', strtotime($resDetail?->updated_at ?? date("d M Y g:i a"))) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-lg-center mb-1">
                                        <span><span><b>Status</b></span> <br> <span class="pl-2"> {{ ucfirst($resDetail->status)}}</span></span>    
                                        <span class="text-right"><span><b>Remarks By:</b></span> <br>{{$resDetail->remarksBy?->name ?? '--'}}</span>    
                                    </div>
                                    <div>
                                        <span class="d-flex justify-content-between"> <span><b>Description</b></span></span>
                                        <p class="text-justify p-2">{{ $resDetail?->remarks ?? '' }}</p>
                                    </div>
                                </div>
                               <div class="col-md-12">
                                    <a href="javscript:void(0);" class="py-1" data-toggle="modal" data-target="#remarks_history">Show Prevoius Remarks</a>
                               </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="rounded" style="border:1px solid #dbdbdb;">
                                <div class="px-2 pt-1 mb-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        @if($resDetail->disputed_type == 'package')
                                        <h5>Message Package Details</h5>                                        
                                        @else
                                        <h5>Reservation Details</h5>                                        
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-2 pt-3 pb-1" style="border-top:1px solid #dbdbdb;">
                                    <table>
                                        <tbody class="table">
                                            <tr>
                                                <td class="font_style">Bank Transaction Id   
                                                </td>                                                
                                                <td class="font-14">{{ $resDetail?->withDraw?->bank_transaction_id ?? 'n/a' }}</td>
                                            </tr>
                                            <tr>
                                                @if($resDetail->disputed_type == 'package')
                                                    <td class="font_style">Message Package Id</td>
                                                    <td class="font-14">{{ $resDetail?->messagePackage?->id }}</td>                                  
                                                @else
                                                    <td class="font_style">Reservation Id</td>
                                                    <td class="font-14">{{ $resDetail?->reservation?->id }}</td>                                 
                                                @endif
                                               
                                            </tr>
                                            <tr>
                                                <td class="font_style">Patient Name</td>
                                                <td class="font-14">{{ $resDetail?->patient?->name }}</td>
                                            </tr>
                                            <tr>
                                                <td class="font_style">Doctor Name</td>
                                                <td class="font-14">{{ $resDetail?->doctor?->name_en }}</td>
                                            </tr>
                                            @if($resDetail->disputed_type == 'package')
                                                <tr>
                                                    <td class="font_style">Package name</td>
                                                    <td class="font-14">
                                                        {{ $resDetail?->messagePackage?->package?->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font_style">Expire date</td>
                                                    <td class="font-14">{{ date('d M Y g:i a', strtotime($resDetail?->messagePackage?->expired_at)) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="font_style">Status</td>
                                                    <td class="font-14">
                                                        <span class="{{ $resDetail?->messagePackage?->expired_at < Carbon\Carbon::now() ? 'text-danger' : 'text-success' }}">
                                                        {{ $resDetail?->messagePackage?->expired_at < Carbon\Carbon::now() ? 'Expired' : 'Active' }}
                                                    </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="font_style">Price</td>
                                                    <td class="font-14">{{ number_format($resDetail?->messagePackage?->price,2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font_style">Doctor Penalty %:</td>
                                                    <td class="font-14">{{ number_format($resDetail?->messagePackage?->penalty_percent,0) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font_style">Price Before Penalty:</td>
                                                    <td class="font-14">{{ number_format($resDetail?->messagePackage?->price_before_penalty,2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font_style">Doctor Payable Before Penalty:</td>
                                                    <td class="font-14">{{ appCommission($resDetail?->messagePackage?->price_before_penalty??$resDetail?->messagePackage?->price?? 0)['payable'] ?? 0.00 }}</td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td class="font_style">Date</td>
                                                    <td class="font-14">{{ date('d M Y', strtotime($resDetail?->reservation?->date)) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="font_style">From Time</td>
                                                    <td class="font-14">
                                                        {{ date('g:i a', strtotime($resDetail?->reservation?->from_time)) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font_style">To Time</td>
                                                    <td class="font-14">{{ date('g:i a', strtotime($resDetail?->reservation?->to_time)) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="font_style">Price</td>
                                                    <td class="font-14">{{ number_format($resDetail?->reservation?->price,2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font_style">Doctor Penalty %:</td>
                                                    <td class="font-14">{{ number_format($resDetail?->reservation?->penalty_percent,0) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font_style">Price Before Penalty:</td>
                                                    <td class="font-14">{{ number_format($resDetail?->reservation?->price_before_penalty,2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font_style">Doctor Payable Before Penalty:</td>
                                                    <td class="font-14">{{ appCommission($resDetail?->reservation?->price_before_penalty??$resDetail?->reservation?->price?? 0)['payable'] ?? 0.00}}</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="p-2" style="font-size: 12px;">
                                <div>
                                    <span
                                        style="margin-right: 5px;">Created</span><span>{{ date('d M Y g:i a', strtotime($resDetail?->reservation?->created_at)) }}</span>
                                </div>
                                <div>
                                    <span style="margin-right: 5px;">Updated
                                    </span><span>{{ date('d M Y g:i a', strtotime($resDetail?->reservation?->updated_at ?? '')) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Add Remarks">
                </div>
            </form>

            {{-- Remarks history modal --}}
            <div id="remarks_history" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="background:#898989;">
                <div class="modal-dialog modal-xl">
                  <div class="modal-content border">
                    <div class="modal-header" style="border-bottom: 1px solid #e3e1e1;">
                        <h5 class="modal-title" id="exampleModalLongTitle">Complaint Remarks History</h5>
                        <button type="button" class="close" data-toggle="modal" data-target="#remarks_history">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>                    
                    <div class="modal-body p-4">
                        <ol type="1">
                            @foreach($resDetail->remarks_history->sortDesc() as $val)
                            <li class="border-bottom mb-2">
                                <div class="p-2"></div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span><span><b>Status</b></span> <br> {{ ucfirst($val->status)}}</span>    
                                    <span><span class="pr-4"><b>Remarks By:</b></span> <br>{{$val->remarksBy->name}}</span>    
                                </div>
                                <div>
                                    <span class="d-flex justify-content-between mr-4"> <span><b>Description</b></span> 
                                    <span>{{ date('d M Y g:i a', strtotime($val?->created_at ?? date('d M Y g:i a'))) }}</span> </span>
                                    <p class="text-justify p-2">{{ $val?->remarks ?? '' }}</p>
                                </div>
                            </li>
                            @endforeach

                        </ol>

                        
                    </div>
                  </div>
                </div>
              </div>

        </div>
    </div>
</div>
