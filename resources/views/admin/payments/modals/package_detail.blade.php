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
<div class="modal fade bd-example-modal-xl" id="package_detail_modal" tabindex="-1" role="dialog"
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
                    <input type="hidden" name="complaint_id" value="{{ $package?->complaint_feedback?->id }} ">
                    <input type="hidden" name="disputed_type" value="package">
                    <div class="row">
                        <div class="col-md-7 pt-2 px-3">
                            <div class="row" style="padding-top: 10px;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Type</label>
                                        <p class="form-control border-0 rounded">
                                            {{ Str::ucfirst($package?->complaint_feedback?->type ?? 'n/a') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group text-right">
                                        <label for="">Lodged On</label>
                                        <p class="form-control border-0 rounded pr-0">
                                            {{ $package?->complaint_feedback?->created_at ? date('d M Y g:i a', strtotime($package?->complaint_feedback?->created_at ?? '')) : '--:--:--' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="">Description</label>
                               <p class="form-control border-0 rounded" style="height: auto;">
                                    {{ $package?->complaint_feedback?->description ?? 'No description given' }}
                                </p>

                            </div>
                            <div class="form-group">
                                <label for="">Add Remarks</label>
                                <textarea class="form-control text-left bg-light border-0 rounded" name="remarks" required
                                @if(!$package?->complaint_feedback) disabled @endif></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Status</label>
                                        <select class="form-control bg-light border-0 rounded" name="status" required="required"
                                        @if(!$package?->complaint_feedback) disabled @endif>
                                            <option disabled selected>Select status</option>
                                            <option value="pending">Pending</option>
                                            <option value="under-investigation">Under Investigation</option>
                                            <option value="resolved">Resolved</option>
                                        </select>                               
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Penalize the Doctor<code style="color: red;">in(%)</code></label>
                                        <div class="input-group">
                                            <input type="number" class="form-control bg-light border-0 rounded" name="penalty"
                                            @if(!$package?->complaint_feedback) disabled @endif
                                            >
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
                                    <div class="d-flex justify-content-between align-items-lg-center">
                                        <h4>Remarks</h4>
                                        <span>{{ date('d M Y g:i a', strtotime($package?->complaint_feedback?->created_at ?? date("d M Y g:i a"))) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span><span><b>Status</b></span> <br> <span class="pl-2"> {{ ucfirst($package?->complaint_feedback?->status)}}</span></span>    
                                        <span class="text-right"><span><b>Remarks By:</b></span> <br>{{$package?->complaint_feedback?->remarksBy?->name? : 'n/a'}}</span>    
                                    </div>
                                    <div>
                                        <span class="d-flex justify-content-between"> <span><b>Description</b></span></span>
                                        <p class="text-justify p-2">{{ $package?->complaint_feedback?->remarks ?? '' }}</p>
                                    </div>
                                </div>
                               <div class="col-md-12">
                                @if(!empty($package->complaint_feedback?->remarks_history->toArray()))
                                    <a href="javscript:void(0);" class="py-1" data-toggle="modal" data-target="#remarks_history">Show Prevoius Remarks</a>
                                @endif
                               </div>
                            </div>


                        </div>

                        <div class="col-md-5">
                            <div class="rounded" style="border:1px solid #dbdbdb;">
                                <div class="px-2 pt-1 mb-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5>Message Package Details</h5>
                                        {{-- <span>
                                            Status:
                                            <span style="margin-left:5px;color: red; font-weight:500;">
                                                {{ strtoupper($package?->reservation_status) }}
                                            </span>
                                        </span> --}}
                                    </div>
                                </div>

                                <div class="mb-2 pt-3 pb-1" style="border-top:1px solid #dbdbdb;">
                                    <table>
                                        <tbody class="table">
                                            <tr>
                                                <td class="font_style">Bank Transaction Id   
                                                </td>                                                
                                                <td class="font-14">{{ $package?->withDraw?->bank_transaction_id ?? 'n/a' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="font_style">Message Package Id</td>
                                                <td class="font-14">{{ $package?->id }}</td>
                                            </tr>
                                            <tr>
                                                <td class="font_style">Patient Name</td>
                                                <td class="font-14">{{ $package?->patient?->name }}</td>
                                            </tr>
                                            <tr>
                                                <td class="font_style">Doctor Name</td>
                                                <td class="font-14">{{ $package?->doctor?->name_en }}</td>
                                            </tr>
                                            <tr>
                                                <td class="font_style">Expire date</td>
                                                <td class="font-14">{{ date('d M Y g:i a', strtotime($package?->expired_at)) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="font_style">Status</td>
                                                <td class="font-14">
                                                    <span class="{{ $package?->expired_at < Carbon\Carbon::now() ? 'text-danger' : 'text-success' }}">
                                                    {{ $package?->expired_at < Carbon\Carbon::now() ? 'Expired' : 'Active' }}
                                                </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="font_style">Price</td>
                                                <td class="font-14">{{ number_format($package?->price,2) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="font_style">Doctor Penalty %:</td>
                                                <td class="font-14">{{ number_format($package?->penalty_percent,0) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="font_style">Price Before Penalty:</td>
                                                <td class="font-14">{{ number_format($package?->price_before_penalty,2) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="font_style">Doctor Payable Before Penalty:</td>
                                                <td class="font-14">{{ appCommission($package?->price_before_penalty??$package?->price??0)['payable'] ?? 0.00}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="p-2" style="font-size: 12px;">
                                <div>
                                    <span
                                        style="margin-right: 5px;">Created At</span><span>{{ date('d M Y g:i a', strtotime($package?->created_at)) }}</span>
                                </div>
                                <div>
                                    <span style="margin-right: 5px;">Updated At:
                                    </span><span>{{ date('d M Y g:i a', strtotime($package?->updated_at ?? '')) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    @if($package?->complaint_feedback)
                        <input type="submit" class="btn btn-primary" value="Save changes">
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>


{{-- Remarks history modal --}}
<div id="remarks_history" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="background:#898989;">
    <div class="modal-dialog modal-xl">
      <div class="modal-content border">
        <div class="modal-header" style="border-bottom: 1px solid #e3e1e1;">
            <h5 class="modal-title" id="exampleModalLongTitle">Complaint Prevoius Remarks History</h5>
            <button type="button" class="close" onclick="closeModal();">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>                    
        <div class="modal-body p-4">
            <ol type="1">
                @if(!empty($package->complaint_feedback?->remarks_history->toArray()))
                    @foreach($package->complaint_feedback->remarks_history as $val)
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
                @else
                    <h5>No prevoius remarks found!</h5>
                @endif

            </ol>

            
        </div>
        {{-- <div class="modal-footer">
            <button type="button" class="btn btn-danger remarks_history-btn" onclick="closeModal();">
                Close</button>
        </div>       --}}
      </div>
    </div>
</div>

<script>
    function disputRemarks() {        
        let data = new FormData($('#addComplaintOrFeedbackRemarks')[0]);

        if(!data.get('status')){
            alert('Please select status.')
            return false
        }else{
            let url = "{{ route('admin.addComplaintOrFeedbackRemarks') }}";
            $.ajax(url, {
                method: 'post',
                processData: false,
                contentType: false,
                cache: false,
                data: data,
                success: function(response) {
                    $('#reservation_detail_modal').modal('hide');
                    $('.modal-backdrop').remove();
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

    }

    function closeModal(){
            $('#remarks_history').modal('hide');
        }
</script>
